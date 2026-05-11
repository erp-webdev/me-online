// We can import `harper.js` using native ECMAScript syntax.
import { WorkerLinter, BinaryModule, Dialect, binaryInlinedUrl } from './harper.js/dist/harper.js';

class SpellChecker {
    constructor(textarea) {
        this.textarea = textarea;
        // The linter needs to be initialized with the wasm binary and a dialect.
        const binary = new BinaryModule(binaryInlinedUrl);
        this.linter = new WorkerLinter({ binary, dialect: Dialect.American });
        this.allLints = [];

        // Shared state for ignored lints across all instances
        this.IGNORED_LINTS_STORAGE_KEY = 'harperjs_ignored_lints';
        this.IGNORE_DURATION_MS = 24 * 60 * 60 * 1000; // 24 hours
        this.ignoredLints = this.loadIgnoredLints();
        this.CUSTOM_DICTIONARY_KEY = 'harperjs_custom_dictionary';
        this.customDictionary = this.loadCustomDictionaryWords();

        this.init();
    }

    async init() {
        this.buildDOM();
        await this.loadDictionaryIntoLinter();
        this.bindEvents();
        this.runLinter(); // Initial check
    }

    buildDOM() {
        const wrapper = document.createElement('div');
        wrapper.className = 'editor-wrapper';
        this.wrapper = wrapper;

        const popover = document.createElement('div');
        popover.className = 'spellcheck-popover';
        this.popover = popover;

        const backdrop = document.createElement('div');
        backdrop.className = 'spellcheck-backdrop editor';
        this.backdrop = backdrop;

        this.textarea.parentNode.insertBefore(wrapper, this.textarea);
        wrapper.appendChild(this.textarea);
        wrapper.appendChild(backdrop);
        wrapper.appendChild(popover);

        this.textarea.classList.add('spellcheck-input', 'editor');
        this.textarea.setAttribute('spellcheck', 'false');

        // Sync height from the original textarea.
        this.textarea.style.height = this.textarea.scrollHeight + 'px';
        this.wrapper.style.height = this.textarea.offsetHeight + 'px';
        this.wrapper.style.width = this.textarea.offsetWidth + 'px';
    }

    bindEvents() {
        // Update backdrop in real-time for text visibility, but only lint on blur.
        this.textarea.addEventListener('input', this.updateBackdropContent.bind(this));
        this.textarea.addEventListener('blur', this.runLinter.bind(this));
        this.textarea.addEventListener('scroll', this.onScroll.bind(this));
        this.backdrop.addEventListener('click', this.onBackdropClick.bind(this));

        // Hide popover when clicking outside of this component's wrapper
        document.addEventListener('click', (e) => {
            if (!this.wrapper.contains(e.target)) {
                this.hidePopover();
            }
        });

        const resizeObserver = new ResizeObserver(() => {
            this.textarea.style.height = this.textarea.scrollHeight + 'px';
            this.wrapper.style.height = this.textarea.offsetHeight + 'px';
            this.wrapper.style.width = this.textarea.offsetWidth + 'px';
        });
        resizeObserver.observe(this.textarea);
    }

    // --- Event Handlers ---
    updateBackdropContent() {
        // This method provides real-time text visibility by updating the backdrop
        // with plain text, without running the linter.
        const text = this.textarea.value;
        this.renderBackdrop(text, []);
    }

    async runLinter() {
        const text = this.textarea.value;
        this.allLints = await this.linter.lint(text);
        this.allLints.sort((a, b) => a.span().start - b.span().start);
        this.renderUI();
    }

    onScroll() {
        this.backdrop.scrollTop = this.textarea.scrollTop;
        this.backdrop.scrollLeft = this.textarea.scrollLeft;
        this.hidePopover();
    }

    onBackdropClick(e) {
        if (e.target.classList.contains('highlight')) {
            const highlightSpan = e.target;
            const lintIndex = parseInt(highlightSpan.dataset.lintIndex, 10);
            const lint = this.allLints[lintIndex];
            this.showPopover(lint, highlightSpan);
        }
    }

    // --- UI Rendering & State ---
    renderUI() {
        const text = this.textarea.value;
        const activeLints = this.allLints.filter(lint => !this.isLintIgnored(lint));

        this.renderBackdrop(text, this.allLints);

        // Update validation classes
        if (activeLints.length > 0) {
            this.wrapper.classList.add('invalid-spellcheck');
            this.wrapper.classList.remove('valid-spellcheck');
        } else {
            this.wrapper.classList.add('valid-spellcheck');
            this.wrapper.classList.remove('invalid-spellcheck');
        }
    }

    renderBackdrop(text, lints) {
        let highlightedHtml = '';
        let lastIndex = 0;

        lints.forEach((lint, index) => {
            const start = lint.span().start;
            const end = lint.span().end;
            highlightedHtml += this.escapeHtml(text.substring(lastIndex, start));
            if (!this.isLintIgnored(lint)) {
                const highlightClass = this.getHighlightClass(lint);
                highlightedHtml += `<span class="highlight ${highlightClass}" data-lint-index="${index}">${this.escapeHtml(text.substring(start, end))}</span>`;
            } else {
                highlightedHtml += this.escapeHtml(text.substring(start, end));
            }
            lastIndex = end;
        });

        highlightedHtml += this.escapeHtml(text.substring(lastIndex));
        this.backdrop.innerHTML = highlightedHtml + '<br>';
    }

    showPopover(lint, highlightSpan) {
        this.popover.innerHTML = ''; // Clear previous content

        const messageDiv = document.createElement('div');
        messageDiv.className = 'message';
        messageDiv.textContent = lint.message();
        this.popover.appendChild(messageDiv);

        // --- Suggestions ---
        const suggestions = lint.suggestions();
        const suggestionsList = document.createElement('ul');
        suggestionsList.className = 'suggestions';

        if (suggestions.length > 0) {
            suggestions.forEach(suggestion => {
                const item = document.createElement('li');
                item.className = 'suggestion';
                item.innerHTML = `Replace with: <span class="suggestion-text">'${this.escapeHtml(suggestion.get_replacement_text())}'</span>`;
                item.addEventListener('click', () => this.applySuggestion(lint, suggestion));
                suggestionsList.appendChild(item);
            });
        } else {
            const noSuggestions = document.createElement('li');
            noSuggestions.className = 'no-suggestions';
            noSuggestions.textContent = 'No suggestions available.';
            suggestionsList.appendChild(noSuggestions);
        }
        this.popover.appendChild(suggestionsList);

        // --- Actions (Ignore, Add to Dictionary) ---
        const actionsList = document.createElement('ul');
        actionsList.className = 'popover-actions';

        // "Add to Dictionary" action
        if (lint.lint_kind() === 'Spelling') {
            const word = this.textarea.value.substring(lint.span().start, lint.span().end);
            const item = document.createElement('li');
            item.className = 'action-item add-dict';
            item.textContent = `Add "${this.escapeHtml(word)}" to dictionary`;
            item.addEventListener('click', async () => {
                await this.addWordToDictionary(word);
                this.hidePopover();
                await this.runLinter(); // Re-lint and re-render the UI
            });
            actionsList.appendChild(item);
        }

        // "Ignore" action
        const ignoreItem = document.createElement('li');
        ignoreItem.className = 'action-item ignore';
        ignoreItem.textContent = 'Ignore this suggestion';
        ignoreItem.addEventListener('click', () => {
            const expiry = Date.now() + this.IGNORE_DURATION_MS;

            // Re-read from storage first to merge with any other instance's ignored lints
            const fresh = this.loadIgnoredLints();
            fresh.set(this.getLintId(lint), expiry);
            this.ignoredLints = fresh;

            this.saveIgnoredLints();
            this.hidePopover();
            this.renderUI();
        });
        actionsList.appendChild(ignoreItem);
        this.popover.appendChild(actionsList);

        // --- Position and show popover ---
        const rect = highlightSpan.getBoundingClientRect();
        const wrapperRect = this.wrapper.getBoundingClientRect();
        this.popover.style.left = `${rect.left - wrapperRect.left}px`;
        this.popover.style.top = `${rect.bottom - wrapperRect.top + 5}px`; // 5px below the highlight
        this.popover.style.display = 'block';
    }

    hidePopover() {
        this.popover.style.display = 'none';
    }

    applySuggestion(lint, suggestion) {
        const text = this.textarea.value;
        const span = lint.span();
        const replacement = suggestion.get_replacement_text();

        this.textarea.value = text.substring(0, span.start) + replacement + text.substring(span.end);

        // Dispatch an input event so that frameworks like Angular/React/Vue can pick up the change.
        this.textarea.dispatchEvent(new Event('input', { bubbles: true, cancelable: true }));

        // Trigger a re-lint
        this.runLinter();
        this.hidePopover();
    }

    // --- Helpers & State Management ---
    loadIgnoredLints() {
        const stored = localStorage.getItem(this.IGNORED_LINTS_STORAGE_KEY);
        if (!stored) return new Map();

        const now = Date.now();
        const storedMap = new Map(JSON.parse(stored));
        // Filter out any entries that have expired.
        const freshMap = new Map([...storedMap].filter(([_, expiry]) => expiry > now));
        return freshMap;
    };

    loadCustomDictionaryWords() {
        const stored = localStorage.getItem(this.CUSTOM_DICTIONARY_KEY);
        return stored ? new Set(JSON.parse(stored)) : new Set();
    }

    loadDictionaryIntoLinter() {
        // The linter's importWords method can take an array of words.
        this.linter.importWords(Array.from(this.customDictionary));
    }

    async addWordToDictionary(word) {
        const wordLower = word.toLowerCase();
        await this.linter.importWords([wordLower]);

        const fresh = this.loadCustomDictionaryWords();
        fresh.add(wordLower);
        this.customDictionary = fresh;

        localStorage.setItem(
            this.CUSTOM_DICTIONARY_KEY,
            JSON.stringify(Array.from(this.customDictionary))
        );
    }

    saveIgnoredLints() {
        localStorage.setItem(this.IGNORED_LINTS_STORAGE_KEY, JSON.stringify(Array.from(this.ignoredLints.entries())));
    };

    getLintId(lint) { return `${lint.span().start}:${lint.span().end}`; }

    isLintIgnored(lint) { return this.ignoredLints.has(this.getLintId(lint)); }

    getHighlightClass(lint) {
        const kind = lint.lint_kind();

        if (kind === 'Spelling') {
            return 'highlight-spelling';
        }

        if (kind === 'Style') {
            return 'highlight-style';
        }

        // Default to grammar for all other rules.
        return 'highlight-grammar';
    }

    escapeHtml(unsafe) {
        return unsafe.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
    }
}

// --- Auto-initialization logic ---

/**
 * Initializes a SpellChecker on a given textarea element.
 * Prevents double-initialization.
 * @param {HTMLTextAreaElement} textarea
 */
const initSpellChecker = (textarea) => {
    // Prevent double-initialization
    if (textarea.dataset.spellcheckerInitialized) return;
    textarea.dataset.spellcheckerInitialized = 'true';
    new SpellChecker(textarea);
};

export function initializeSpellingChecker() { 
    document.querySelectorAll('textarea.spellcheck').forEach(initSpellChecker);

    // Observe the body for new textareas being added dynamically
    const observer = new MutationObserver((mutationsList) => {
        for (const mutation of mutationsList) {
            if (mutation.type === 'childList') {
                mutation.addedNodes.forEach(node => {
                    if (node.nodeType === 1 && node.matches('textarea.spellcheck')) initSpellChecker(node);
                    if (node.nodeType === 1) node.querySelectorAll('textarea.spellcheck').forEach(initSpellChecker);
                });
            }
        }
    });

    observer.observe(document.body, { childList: true, subtree: true });
}
