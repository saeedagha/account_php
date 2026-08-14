<code>
CREATE TABLE `document_templates` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(255) NOT NULL,
`operation_type` varchar(50) NOT NULL,
`hesab_bed` int(11) DEFAULT NULL,
`hesab_bes` int(11) DEFAULT NULL,
`sharh` varchar(255) DEFAULT NULL,
`active` tinyint(1) NOT NULL DEFAULT 1,
`created_at` timestamp NOT NULL DEFAULT current_timestamp(),
`updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),

    PRIMARY KEY (`id`),

    KEY `idx_operation_type` (`operation_type`),
    KEY `idx_active` (`active`),
    KEY `idx_hesab_bed` (`hesab_bed`),
    KEY `idx_hesab_bes` (`hesab_bes`),

    CONSTRAINT `document_templates_fk_bed`
        FOREIGN KEY (`hesab_bed`)
        REFERENCES `hesabha` (`id`)
        ON DELETE SET NULL
        ON UPDATE CASCADE,

    CONSTRAINT `document_templates_fk_bes`
        FOREIGN KEY (`hesab_bes`)
        REFERENCES `hesabha` (`id`)
        ON DELETE SET NULL
        ON UPDATE CASCADE

) ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE=utf8_persian_ci;</code>