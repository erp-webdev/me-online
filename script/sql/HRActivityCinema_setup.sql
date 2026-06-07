USE [SUBSIDIARY]
GO

IF OBJECT_ID('dbo.HRActivityCinemaConfig', 'U') IS NULL
BEGIN
    CREATE TABLE dbo.HRActivityCinemaConfig
    (
        activity_id INT NOT NULL,
        activity_db VARCHAR(30) NOT NULL,
        is_cinema_screening TINYINT NOT NULL DEFAULT(0),
        consolidate_pool TINYINT NOT NULL DEFAULT(0),
        pool_code VARCHAR(100) NULL,
        updated_date INT NOT NULL,
        CONSTRAINT PK_HRActivityCinemaConfig PRIMARY KEY (activity_id, activity_db)
    );
END
GO

IF OBJECT_ID('dbo.HRActivityCinemaCapacity', 'U') IS NULL
BEGIN
    CREATE TABLE dbo.HRActivityCinemaCapacity
    (
        cinema_capacity_id INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
        activity_id INT NOT NULL,
        activity_db VARCHAR(30) NOT NULL,
        pool_code VARCHAR(100) NOT NULL,
        cinema_name VARCHAR(150) NOT NULL,
        seat_capacity INT NOT NULL,
        updated_date INT NOT NULL
    );
END
GO

IF NOT EXISTS (SELECT 1 FROM sys.indexes WHERE name = 'IX_HRActivityCinemaCapacity_pool_db' AND object_id = OBJECT_ID('dbo.HRActivityCinemaCapacity'))
BEGIN
    CREATE INDEX IX_HRActivityCinemaCapacity_pool_db
    ON dbo.HRActivityCinemaCapacity(pool_code, activity_db, cinema_name);
END
GO

IF NOT EXISTS (SELECT 1 FROM sys.indexes WHERE name = 'IX_HRActivityCinemaCapacity_activity_db' AND object_id = OBJECT_ID('dbo.HRActivityCinemaCapacity'))
BEGIN
    CREATE INDEX IX_HRActivityCinemaCapacity_activity_db
    ON dbo.HRActivityCinemaCapacity(activity_id, activity_db);
END
GO
