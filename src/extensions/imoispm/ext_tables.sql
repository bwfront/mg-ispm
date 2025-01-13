CREATE TABLE tx_ispm_domain_model_imoobjects (
	city varchar(255) NOT NULL DEFAULT '',
	state varchar(255) NOT NULL DEFAULT '',
	street varchar(255) NOT NULL DEFAULT '',
	streetnumber varchar(255) NOT NULL DEFAULT '',
	postalcode varchar(255) NOT NULL DEFAULT '0',
	units int(11) NOT NULL DEFAULT '0',
);

CREATE TABLE tx_ispm_domain_model_imounits (
	chiffre varchar(255) NOT NULL DEFAULT '',
	number varchar(255) NOT NULL DEFAULT '',
	placeholder varchar(255) NOT NULL DEFAULT '',
	offer varchar(255) NOT NULL DEFAULT '',
	imoobjectuid int(11) NOT NULL DEFAULT '0'
);

CREATE TABLE tx_ispm_domain_model_imochiffre (
    chiffre varchar(255) NOT NULL DEFAULT '',
    objectnr int(11) NOT NULL DEFAULT '0',
    unitnr int(11) NOT NULL DEFAULT '0',
    userid int(11) NOT NULL DEFAULT '0'
);

CREATE TABLE tx_ispm_domain_model_chiffrelog (
	usercookie varchar(255) NOT NULL DEFAULT '',
	userip varchar(255) NOT NULL DEFAULT '',
	chiffre varchar(255) NOT NULL DEFAULT '',
	objectnr int(11) NOT NULL DEFAULT '0',
	unitnr int(11) NOT NULL DEFAULT '0',
);

CREATE TABLE tx_ispm_domain_model_userdata (
	usercookie varchar(255) NOT NULL DEFAULT '',
	chiffre varchar(255) NOT NULL DEFAULT '',
	objectnr int(11) NOT NULL DEFAULT '0',
	unitnr int(11) NOT NULL DEFAULT '0',
    salutation VARCHAR(10) NOT NULL DEFAULT '',
    firstname VARCHAR(255) NOT NULL DEFAULT '',
    surname VARCHAR(255) NOT NULL DEFAULT '',
    email VARCHAR(255) NOT NULL DEFAULT '',
    telefon VARCHAR(255) NOT NULL DEFAULT ''
);

CREATE TABLE tx_ispm_domain_model_frontenduser (
    username VARCHAR(255) DEFAULT '' NOT NULL,
    password VARCHAR(255) DEFAULT '' NOT NULL,
    first_name VARCHAR(255) DEFAULT '',
    last_name VARCHAR(255) DEFAULT '',
    email VARCHAR(255) DEFAULT '' NOT NULL
);
