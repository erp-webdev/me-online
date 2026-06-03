USE [SUBSIDIARY]
GO
SET NOCOUNT ON;

/*
Test harness for dbo.SP_ADD_REGISTER deterministic status codes.

Expected status codes:
-1 = invalid cinema
-2 = duplicate registration
-3 = cinema full
>0 = success (registry_id)

IMPORTANT:
1) Set @ActivityId and @DbName to valid values in your environment.
2) This script runs inside a transaction and always ROLLBACKs at the end.
*/

DECLARE @ActivityId INT = 3296;                  -- TODO: set a valid activity_id
DECLARE @DbName VARCHAR(30) = 'ME';              -- TODO: set valid tenant DB code
DECLARE @Cinema VARCHAR(50) = 'Lucky Chinatown Cinemas';

DECLARE @Status INT;
DECLARE @NowUnix INT = DATEDIFF(SECOND, '19700101', GETUTCDATE());
DECLARE @Capacity INT;
DECLARE @Occupied INT;
DECLARE @SeedNeeded INT;
DECLARE @i INT;
DECLARE @Uid VARCHAR(64);

SET @Capacity = CASE @Cinema
    WHEN 'Uptown Cinemas' THEN 816
    WHEN 'Eastwood Cinemas' THEN 472
    WHEN 'Venice Cineplex' THEN 904
    WHEN 'Festivewalk Iloilo Cinemas' THEN 345
    WHEN 'Newport Cinemas' THEN 336
    WHEN 'Lucky Chinatown Cinemas' THEN 290
    WHEN 'Southwoods Cinemas' THEN 319
    ELSE NULL
END;

IF @Capacity IS NULL
BEGIN
    RAISERROR('Invalid @Cinema in test harness.', 16, 1);
    RETURN;
END;

IF NOT EXISTS (SELECT 1 FROM dbo.HRActivity WHERE activity_id = @ActivityId)
BEGIN
    RAISERROR('Invalid @ActivityId: activity does not exist.', 16, 1);
    RETURN;
END;

BEGIN TRY
    BEGIN TRANSACTION;

    PRINT '--- CASE 1: INVALID CINEMA (expect -1) ---';
    EXEC dbo.SP_ADD_REGISTER
         @registry_activityid = @ActivityId,
         @registry_uid = 'TST_INV_' + REPLACE(CONVERT(VARCHAR(36), NEWID()), '-', ''),
         @registry_offidnum = NULL,
         @registry_offname = NULL,
         @registry_offcomp = 0,
         @registry_offpos = NULL,
         @registry_godirectly = 1,
         @registry_vrin = 0,
         @registry_vrout = 0,
         @registry_details = NULL,
         @registry_platenum = NULL,
         @registry_child = 0,
         @registry_dependent = 0,
         @registry_guest = 0,
         @registry_date = @NowUnix,
         @registry_dateattend = 0,
         @registry_approver = NULL,
         @registry_auto = 0,
         @registry_offsite = 0,
         @registry_status = 2,
         @registry_db = @DbName,
         @registry_vaxpath = NULL,
         @registry_vaxstatus = NULL,
         @registry_vaxlastdate = @NowUnix,
         @registry_location = 'INVALID CINEMA',
         @registry_pickup_location = 'AGT',
         @STATUS = @Status OUTPUT;

    SELECT 'CASE_INVALID_CINEMA' AS test_case, @Status AS status;

    PRINT '--- CASE 2: DUPLICATE REGISTRATION (expect >0 then -2) ---';
    SET @Uid = 'TST_DUP_' + REPLACE(CONVERT(VARCHAR(36), NEWID()), '-', '');

    EXEC dbo.SP_ADD_REGISTER
         @registry_activityid = @ActivityId,
         @registry_uid = @Uid,
         @registry_offidnum = NULL,
         @registry_offname = NULL,
         @registry_offcomp = 0,
         @registry_offpos = NULL,
         @registry_godirectly = 1,
         @registry_vrin = 0,
         @registry_vrout = 0,
         @registry_details = NULL,
         @registry_platenum = NULL,
         @registry_child = 0,
         @registry_dependent = 0,
         @registry_guest = 0,
         @registry_date = @NowUnix,
         @registry_dateattend = 0,
         @registry_approver = NULL,
         @registry_auto = 0,
         @registry_offsite = 0,
         @registry_status = 2,
         @registry_db = @DbName,
         @registry_vaxpath = NULL,
         @registry_vaxstatus = NULL,
         @registry_vaxlastdate = @NowUnix,
         @registry_location = @Cinema,
         @registry_pickup_location = 'AGT',
         @STATUS = @Status OUTPUT;

    SELECT 'CASE_DUPLICATE_FIRST_CALL' AS test_case, @Status AS status;

    EXEC dbo.SP_ADD_REGISTER
         @registry_activityid = @ActivityId,
         @registry_uid = @Uid,
         @registry_offidnum = NULL,
         @registry_offname = NULL,
         @registry_offcomp = 0,
         @registry_offpos = NULL,
         @registry_godirectly = 1,
         @registry_vrin = 0,
         @registry_vrout = 0,
         @registry_details = NULL,
         @registry_platenum = NULL,
         @registry_child = 0,
         @registry_dependent = 0,
         @registry_guest = 0,
         @registry_date = @NowUnix,
         @registry_dateattend = 0,
         @registry_approver = NULL,
         @registry_auto = 0,
         @registry_offsite = 0,
         @registry_status = 2,
         @registry_db = @DbName,
         @registry_vaxpath = NULL,
         @registry_vaxstatus = NULL,
         @registry_vaxlastdate = @NowUnix,
         @registry_location = @Cinema,
         @registry_pickup_location = 'AGT',
         @STATUS = @Status OUTPUT;

    SELECT 'CASE_DUPLICATE_SECOND_CALL' AS test_case, @Status AS status;

    PRINT '--- CASE 3: FULL CINEMA (expect -3) ---';

    SELECT @Occupied = COUNT(*)
    FROM dbo.HREventRegistry
    WHERE registry_status >= 1
      AND registry_activityid = @ActivityId
      AND ISNULL(registry_db, '') = ISNULL(@DbName, '')
      AND registry_location = @Cinema;

    SET @SeedNeeded = @Capacity - @Occupied;
    IF @SeedNeeded < 0 SET @SeedNeeded = 0;

    SET @i = 1;
    WHILE @i <= @SeedNeeded
    BEGIN
        EXEC dbo.SP_ADD_REGISTER
             @registry_activityid = @ActivityId,
             @registry_uid = 'TST_FILL_' + RIGHT('000000' + CAST(@i AS VARCHAR(6)), 6) + '_' + REPLACE(CONVERT(VARCHAR(36), NEWID()), '-', ''),
             @registry_offidnum = NULL,
             @registry_offname = NULL,
             @registry_offcomp = 0,
             @registry_offpos = NULL,
             @registry_godirectly = 1,
             @registry_vrin = 0,
             @registry_vrout = 0,
             @registry_details = NULL,
             @registry_platenum = NULL,
             @registry_child = 0,
             @registry_dependent = 0,
             @registry_guest = 0,
             @registry_date = @NowUnix,
             @registry_dateattend = 0,
             @registry_approver = NULL,
             @registry_auto = 0,
             @registry_offsite = 0,
             @registry_status = 2,
             @registry_db = @DbName,
             @registry_vaxpath = NULL,
             @registry_vaxstatus = NULL,
             @registry_vaxlastdate = @NowUnix,
             @registry_location = @Cinema,
             @registry_pickup_location = 'AGT',
             @STATUS = @Status OUTPUT;

        IF @Status <= 0
        BEGIN
            SELECT 'CASE_FILL_UNEXPECTED_FAILURE' AS test_case, @i AS fill_index, @Status AS status;
            BREAK;
        END;

        SET @i = @i + 1;
    END;

    EXEC dbo.SP_ADD_REGISTER
         @registry_activityid = @ActivityId,
         @registry_uid = 'TST_OVER_' + REPLACE(CONVERT(VARCHAR(36), NEWID()), '-', ''),
         @registry_offidnum = NULL,
         @registry_offname = NULL,
         @registry_offcomp = 0,
         @registry_offpos = NULL,
         @registry_godirectly = 1,
         @registry_vrin = 0,
         @registry_vrout = 0,
         @registry_details = NULL,
         @registry_platenum = NULL,
         @registry_child = 0,
         @registry_dependent = 0,
         @registry_guest = 0,
         @registry_date = @NowUnix,
         @registry_dateattend = 0,
         @registry_approver = NULL,
         @registry_auto = 0,
         @registry_offsite = 0,
         @registry_status = 2,
         @registry_db = @DbName,
         @registry_vaxpath = NULL,
         @registry_vaxstatus = NULL,
         @registry_vaxlastdate = @NowUnix,
         @registry_location = @Cinema,
         @registry_pickup_location = 'AGT',
         @STATUS = @Status OUTPUT;

    SELECT 'CASE_FULL_CINEMA_OVERFLOW' AS test_case, @Status AS status;

    ROLLBACK TRANSACTION;

    PRINT 'Test harness completed. Transaction rolled back.';
END TRY
BEGIN CATCH
    IF @@TRANCOUNT > 0
        ROLLBACK TRANSACTION;

    DECLARE @Err NVARCHAR(4000) = ERROR_MESSAGE();
    RAISERROR('Test harness failed: %s', 16, 1, @Err);
END CATCH;
GO
