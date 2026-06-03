USE [SUBSIDIARY]
GO
/****** Object:  StoredProcedure [dbo].[SP_ADD_REGISTER]    Script Date: 2/6/2026 3:09:38 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

ALTER PROCEDURE [dbo].[SP_ADD_REGISTER]
       @registry_activityid            INT,
       @registry_uid                   VARCHAR(MAX) = NULL,
       @registry_offidnum              VARCHAR(MAX) = NULL,
       @registry_offname               VARCHAR(MAX) = NULL,
       @registry_offcomp               TINYINT,
       @registry_offpos                VARCHAR(MAX) = NULL,
       @registry_godirectly            TINYINT,
       @registry_vrin                  TINYINT,
       @registry_vrout                 TINYINT,
       @registry_details               VARCHAR(MAX) = NULL,
       @registry_platenum              VARCHAR(MAX) = NULL,
       @registry_child                 TINYINT,
       @registry_dependent             TINYINT,
       @registry_guest                 TINYINT,
       @registry_date                  INT,
       @registry_dateattend            INT,
       @registry_approver              VARCHAR(MAX) = NULL,
       @registry_auto                  TINYINT,
       @registry_offsite               TINYINT,
       @registry_status                TINYINT,
       @registry_db                    VARCHAR(30) = NULL,
       @registry_vaxpath               VARCHAR(MAX) = NULL,
       @registry_vaxstatus             VARCHAR(50) = NULL,
       @registry_vaxlastdate           INT,
       @registry_location              VARCHAR(50) = NULL,
       @registry_pickup_location       VARCHAR(100) = NULL,
       @STATUS                         INT OUTPUT
AS
BEGIN
    SET NOCOUNT ON;
    SET XACT_ABORT ON;

    -- STATUS code contract:
    --  >0 : registry_id (success)
    --  -1 : invalid cinema
    --  -2 : duplicate registration
    --  -3 : cinema full
    --  -4 : sql error

    DECLARE @cinema_capacity INT;
    DECLARE @cinema_occupied INT;

    SET @STATUS = 0;

    BEGIN TRY
        BEGIN TRANSACTION;

        SET @cinema_capacity = CASE @registry_location
            WHEN 'Uptown Cinemas' THEN 816
            WHEN 'Eastwood Cinemas' THEN 472
            WHEN 'Venice Cineplex' THEN 904
            WHEN 'Festivewalk Iloilo Cinemas' THEN 345
            WHEN 'Newport Cinemas' THEN 336
            WHEN 'Lucky Chinatown Cinemas' THEN 290
            WHEN 'Southwoods Cinemas' THEN 319
            ELSE NULL
        END;

        IF @cinema_capacity IS NULL
        BEGIN
            ROLLBACK TRANSACTION;
            SET @STATUS = -1;
            RETURN;
        END;

        IF EXISTS (
            SELECT 1
            FROM [HREventRegistry] WITH (UPDLOCK, HOLDLOCK)
            WHERE registry_status >= 1
              AND registry_activityid = @registry_activityid
              AND registry_uid = @registry_uid
              AND ISNULL(registry_db, '') = ISNULL(@registry_db, '')
        )
        BEGIN
            ROLLBACK TRANSACTION;
            SET @STATUS = -2;
            RETURN;
        END;

        SELECT @cinema_occupied = COUNT(*)
        FROM [HREventRegistry] WITH (UPDLOCK, HOLDLOCK)
        WHERE registry_status >= 1
          AND registry_activityid = @registry_activityid
          AND ISNULL(registry_db, '') = ISNULL(@registry_db, '')
          AND registry_location = @registry_location;

        IF @cinema_occupied >= @cinema_capacity
        BEGIN
            ROLLBACK TRANSACTION;
            SET @STATUS = -3;
            RETURN;
        END;

        INSERT INTO [HREventRegistry]
              (registry_activityid, registry_uid, registry_offidnum, registry_offname, registry_offcomp,
              registry_offpos, registry_godirectly, registry_vrin, registry_vrout, registry_details,
              registry_platenum, registry_child, registry_dependent, registry_guest, registry_date,
              registry_dateattend, registry_approver, registry_auto, registry_offsite, registry_status,
              registry_db, registry_vaxpath, registry_vaxstatus, registry_vaxlastdate, registry_location,
              registry_pickup_location)
         VALUES
              (@registry_activityid, @registry_uid, @registry_offidnum, @registry_offname, @registry_offcomp,
              @registry_offpos, @registry_godirectly, @registry_vrin, @registry_vrout, @registry_details,
              @registry_platenum, @registry_child, @registry_dependent, @registry_guest, @registry_date,
              @registry_dateattend, @registry_approver, @registry_auto, @registry_offsite, @registry_status,
              @registry_db, @registry_vaxpath, @registry_vaxstatus, @registry_vaxlastdate, @registry_location,
              @registry_pickup_location);

        SET @STATUS = SCOPE_IDENTITY();

        COMMIT TRANSACTION;
    END TRY
    BEGIN CATCH
        IF @@TRANCOUNT > 0
            ROLLBACK TRANSACTION;

        SET @STATUS = -4;
    END CATCH;
END
GO
