var path = 'https://portal.megaworldcorp.com/me/';

var tour = new Tour({
  name: "PMS",
  steps: [],
  container: "body",
  smartPlacement: true,
  keyboard: true,
  storage: window.localStorage,
  debug: false,
  backdrop: true,
  backdropContainer: 'body',
  backdropPadding: 0,
  redirect: false,
  orphan: false,
  duration: false,
  delay: false,
  basePath: "",
  // template: template,
  afterGetState: function (key, value) {},
  afterSetState: function (key, value) {},
  afterRemoveState: function (key, value) {},
  onStart: function (tour) {},
  onEnd: function (tour) {},
  onShow: function (tour) {},
  onShown: function (tour) {},
  onHide: function (tour) {},
  onHidden: function (tour) {},
  onNext: function (tour) {},
  onPrev: function (tour) {},
  onPause: function (tour, duration) {},
  onResume: function (tour, duration) {},
  onRedirectError: function (tour) {}
});

// STEP 1: Welcome
tour.addStep({
  path: path,
  // host: "",
  // element: "",
  placement: "center",
  smartPlacement: true,
  title: "Performance Management System",
  content: "Welcome to Performance Management System" + "<br/><br/> Click Next to continue",
  // next: 0,
  // prev: 0,
  animation: true,
  container: "body",
  backdrop: false,
  backdropContainer: 'body',
  // backdropPadding: false,
  // redirect: true,
  reflex: false,
  // orphan: false,
  // template: "",
  // onShow: function (tour) {
  // },
  // onShown: function (tour) {},
  // onHide: function (tour) {},
  // onHidden: function (tour) {},
  // onNext: function (tour) {},
  // onPrev: function (tour) {},
  // onPause: function (tour) {},
  // onResume: function (tour) {},
  // onRedirectError: function (tour) {}
});

// menu location
tour.addStep({
  path: path,
  element: 'a[href="' + path +'paf"]',
  placement: "right",
  smartPlacement: true,
  title: "Performance Management System",
  content: "Click 'Performance Management'",
  animation: true,
  container: "body",
  backdrop: true,
  backdropContainer: 'body',
  backdropPadding: true,
  // reflex: true,
  // onNext: function(){
  //   document.location.href = path + 'paf';
  //   return (new jQuery.Deferred()).promise();
  // }
});

// Appraisal Groups
tour.addStep({
  path: path + 'paf',
  element: '#paf',
  // placement: "center",
  smartPlacement: true,
  title: "Appraisal Groups",
  content: "List of all previous and current appraisal groups",
  animation: true,
  container: "body",
  backdrop: true,
  backdropContainer: 'body',
  backdropPadding: true,
});

// Megaworld Group view btn
tour.addStep({
  path: path + 'paf',
  element: '#group66',
  // placement: "center",
  smartPlacement: true,
  title: "Megaworld Appraisal Group",
  content: "Contains all Megaworld employees for your evaluation and/or approval",
  animation: true,
  container: "body",
  backdrop: true,
  backdropContainer: 'body',
  backdropPadding: true,
  // onNext: function(){
  //   // document.location.href = path + 'paf?groupid=66';
  //   return (new jQuery.Deferred()).promise();
  // }
});

// Megaworld Group view btn
tour.addStep({
  path: path + 'paf',
  element: 'a[href="'+ path +'paf?groupid=66"]',
  // placement: "center",
  smartPlacement: true,
  title: "Megaworld Appraisal Group",
  content: "Click to view the list",
  animation: true,
  container: "body",
  backdrop: true,
  backdropContainer: 'body',
  backdropPadding: true,
  // onNext: function(){
  //   // document.location.href = path + 'paf?groupid=66';
  //   return (new jQuery.Deferred()).promise();
  // }
});

// Megaworld Employees
tour.addStep({
  path: path + 'paf?groupid=66',
  element: '#tabslist',
  // placement: "center",
  smartPlacement: true,
  title: "Megaworld Employees",
  content: "List of all Megaworld Employees for your evaluation and/or approval",
  animation: true,
  container: "body",
  backdrop: true,
  backdropContainer: 'body',
  backdropPadding: false,
});

// Evaluator Button
tour.addStep({
  // path: path + 'paf?groupid=66',
  element: 'li[aria-labelledby="ui-id-1"]',
  placement: "top",
  smartPlacement: true,
  title: "Evaluator",
  content: "Contains all employees for your evaluation",
  animation: true,
  container: "body",
  backdrop: false,
  backdropContainer: 'body',
  backdropPadding: false,
  // reflex: true
  // onShow: function(tour){
  //   $('li[aria-labelledby="ui-id-1"]').click();
  // }
});


// // second approver
// tour.addStep({
//   // path: path + 'paf?groupid=66',
//   element: 'li[aria-labelledby="ui-id-2"]',
//   placement: "top",
//   smartPlacement: true,
//   title: "Second Approver",
//   content: "Contains all evaluated employees for your second or final approval.",
//   animation: true,
//   container: "body",
//   backdrop: false,
//   backdropContainer: 'body',
//   backdropPadding: true,
//   // onShow: function(tour){
//   //   $('li[aria-labelledby="ui-id-2"]').click();
//   // }
// });

// // third approver
// tour.addStep({
//   // path: path + 'paf?groupid=66',
//   element: 'li[aria-labelledby="ui-id-3"]',
//   placement: "top",
//   smartPlacement: true,
//   title: "Third Approver",
//   content: "Contains all evaluated employees for your third or final approval.",
//   animation: true,
//   container: "body",
//   backdrop: false,
//   backdropContainer: 'body',
//   backdropPadding: false,
//   // onShow: function(tour){
//   //   $('li[aria-labelledby="ui-id-3"]').click();
//   // }
// });

// // fourth approver
// tour.addStep({
//   // path: path + 'paf?groupid=66',
//   element: 'li[aria-labelledby="ui-id-4"]',
//   placement: "top",
//   smartPlacement: true,
//   title: "Fourth Approver",
//   content: "Contains all evaluated employees for your fourth or final approval.",
//   animation: true,
//   container: "body",
//   backdrop: false,
//   backdropContainer: 'body',
//   backdropPadding: false,
//   onNext: function(tour){
//      $('li[aria-labelledby="ui-id-1"]').find('a').click();
//   }
//   // onShow: function(tour){
//   //   $('li[aria-labelledby="ui-id-4"]').click();
//   // }
// });

// Row of Employee for evaluation
tour.addStep({
  path: path + 'paf?groupid=66',
  element: $('div#tabs-1').find('table.tdata').find("tr[id^='emp'").first(),
  // placement: "center",
  smartPlacement: true,
  title: "Employee for Evaluation",
  content: "Employee for your evaluation",
  animation: true,
  container: "body",
  backdrop: true,
  backdropContainer: 'body',
  backdropPadding: false,
});

// Row of Employee for evaluation
// tour.addStep({
//   path: path + 'paf?groupid=66',
//   element: $('div#tabs-1').find('table.tdata').find('a:contains("Rate")').parents('tr[id^="emp"]').first(),
//   // placement: "center",
//   smartPlacement: true,
//   title: "Employee for Evaluation",
//   content: "Employee for your evaluation",
//   animation: true,
//   container: "body",
//   backdrop: true,
//   backdropContainer: 'body',
//   backdropPadding: false,
// });

// Rate btn under Evaluator
tour.addStep({
  path: path + 'paf?groupid=66',
  element: $('div#tabs-1').find('table.tdata').find('a:contains("Rate")').first(),
  placement: "left",
  smartPlacement: true,
  title: "Evaluating Employees",
  content: "Click to start the evaluation of the selected employee.",
  animation: true,
  container: "body",
  backdrop: false,
  backdropContainer: 'body',
  backdropPadding: false,
});

// Evaluation Form
// tour.addStep({
//   path: path + 'paf?groupid=66&appid=\d&rid=\d',
//   element: '#pafevaluate',
//   placement: "top",
//   smartPlacement: true,
//   title: "Megaworld Evaluation Form",
//   content: "The evaluation for Megaworld Employees consists of 3 Parts",
//   animation: true,
//   container: "body",
//   backdrop: true,
//   backdropContainer: 'body',
//   backdropPadding: false,
//   onShow: function(tour){
//     $('div.print').removeAttr('style');
//   }
// });

// // Evaluation Form Part I
// tour.addStep({
//   path: path + 'paf?groupid=66&appid=\d&rid=\d',
//   element: '#comass',
//   placement: "left",
//   smartPlacement: true,
//   title: "Evaluation Form Part I",
//   content: "Staff Member's Competencies Assessment",
//   animation: true,
//   container: "body",
//   backdrop: true,
//   backdropContainer: 'body',
//   backdropPadding: false,
//   onShow: function(tour){
//     $('div.print').removeAttr('style');
//   }
// });

// // Evaluation Form Part II
// tour.addStep({
//   path: path + 'paf?groupid=66&appid=\d&rid=\d',
//   element: '#gcutep',
//   placement: "left",
//   smartPlacement: true,
//   title: "Evaluation Form Part II",
//   content: "Goals from previous year or previous evaluation period",
//   animation: true,
//   container: "body",
//   backdrop: true,
//   backdropContainer: 'body',
//   backdropPadding: false,
//   onShow: function(tour){
//     $('div.print').removeAttr('style');
//   }
// });

// // Evaluation Form Part III
// tour.addStep({
//   path: path + 'paf?groupid=66&appid=\d&rid=\d',
//   element: '#gftcyoep',
//   placement: "left",
//   smartPlacement: true,
//   title: "Evaluation Form Part III",
//   content: "Goals for the coming year or evaluation period",
//   animation: true,
//   container: "body",
//   backdrop: true,
//   backdropContainer: 'body',
//   backdropPadding: false,
//   onShow: function(tour){
//     $('div.print').removeAttr('style');
//   }
// });


// Evaluation Form Part I - Evaluation Process
// tour.addStep({
//   path: path + 'paf?groupid=66&appid=\d&rid=\d',
//   element: "b:contains('Part I - Staff Member\.')",
//   placement: "top",
//   smartPlacement: true,
//   title: "Evaluation Form Part I",
//   content: "Rating Parameters",
//   animation: true,
//   container: "body",
//   backdrop: false,
//   backdropContainer: 'body',
//   backdropPadding: false,
//   onShow: function(tour){
//     $('div.print').removeAttr('style');
//   }
// });

// Initialize the tour
tour.init();

// Start the tour
tour.start();