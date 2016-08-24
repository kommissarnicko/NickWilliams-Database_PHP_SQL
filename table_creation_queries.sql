CREATE TABLE `family`
(
    `id`        int                 AUTO_INCREMENT,
    `name`          varchar(255)    NOT NULL,
    PRIMARY KEY(id),
    CONSTRAINT `name_unique`        UNIQUE(name)
) ENGINE=InnoDB;

CREATE TABLE `person`
(
    `id`    int                     AUTO_INCREMENT,
    `first_name`    varchar(255)    NOT NULL,
    `middle_name`   varchar(255),
    `loyalty`       int,
    `age`           int            NOT NULL,
    PRIMARY KEY(id),
    CONSTRAINT `person_fk` FOREIGN KEY(loyalty) REFERENCES family(id),
    CONSTRAINT `f_m_name_unique`    UNIQUE(first_name, middle_name)
) ENGINE=InnoDB;

CREATE TABLE `fief`
(
    `id`        int             AUTO_INCREMENT,
    `name`      varchar(255)    NOT NULL,
    `owner`     int,
    PRIMARY KEY(id),
    CONSTRAINT `fief_fk1` FOREIGN KEY(owner) REFERENCES family(id),
    CONSTRAINT `name_unique`    UNIQUE(name)
) ENGINE=InnoDB;

CREATE TABLE `asset`
(
    `id`            int             AUTO_INCREMENT,
    `name`          varchar(255)    NOT NULL,
    `description`   varchar(255),
    PRIMARY KEY(id),
    CONSTRAINT `name_desc_unique`        UNIQUE(name, description)
) ENGINE=InnoDB;

CREATE TABLE `parent_child`
(
    `pid`       int,
    `cid`       int,
    CONSTRAINT `parent_child_pk` PRIMARY KEY(pid, cid),
    CONSTRAINT `parent_child_fk1` FOREIGN KEY(pid) REFERENCES person(id),
    CONSTRAINT `parent_child_fk2` FOREIGN KEY(cid) REFERENCES person(id),
    CONSTRAINT `pid_cid_unique` UNIQUE (pid, cid)
) ENGINE=InnoDB;

CREATE TABLE `lord_vassal`
(
    `lid`       int,
    `vid`       int,
    CONSTRAINT `lord_vassal_pk` PRIMARY KEY(lid, vid),
    CONSTRAINT `lord_vassal_fk1` FOREIGN KEY(lid) REFERENCES family(id),
    CONSTRAINT `lord_vassal_fk2` FOREIGN KEY(vid) REFERENCES family(id),
    CONSTRAINT `lid_vid_unique` UNIQUE (lid, vid)
) ENGINE=InnoDB;

CREATE TABLE `fief_asset`
(
    `fid`       int,
    `aid`       int,
    `quantity`  int                 NOT NULL,
    CONSTRAINT `fief_asset_pk` PRIMARY KEY(fid, aid),
    CONSTRAINT `fief_asset_fk1` FOREIGN KEY(fid) REFERENCES fief(id),
    CONSTRAINT `fief_asset__fk2` FOREIGN KEY(aid) REFERENCES asset(id),
    CONSTRAINT `fid, aid_unique` UNIQUE (fid, aid)
) ENGINE=InnoDB;