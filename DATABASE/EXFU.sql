-- DATABASE
drop database if exists rexfur;
create database rexfur;
use rexfur;

-- set foreign_key_checks = 0;

-- MODEL
create table galaxy(
	id int(11) NOT NULL AUTO_INCREMENT,
	strname varchar(20) NOT NULL,
    primary key(id)
)engine=innodb;

create table solarsystem(
	id int(11) NOT NULL AUTO_INCREMENT,
	strname varchar(20) NOT NULL,
    intpositionx int(5) NOT NULL,
    intpositiony int(5) NOT NULL,
    fk_galaxy int(11) NOT NULL,
    primary key(id),
    foreign key(fk_galaxy) references galaxy(id)
)engine=innodb;

create table planet(
	id int(11) NOT NULL AUTO_INCREMENT,
	strname varchar(20) NOT NULL,
    inttype int(5) DEFAULT 0,
    intgravity int(5) DEFAULT 100,
    intradiation int(5) DEFAULT 0,
    intposition int(5) NOT NULL,
    introtation int(5) DEFAULT 1,
    fk_solarsystem int(11) NOT NULL,
    primary key(id),
    foreign key(fk_solarsystem) references solarsystem(id)
)engine=innodb;

create table npc(
	id int(11) NOT NULL AUTO_INCREMENT,
	strname varchar(20) NOT NULL,
    inttype int(5) DEFAULT 0,
    strappearancepath varchar(50),
    fk_planet int(11) NOT NULL,
    primary key(id),
    foreign key(fk_planet) references planet(id)
)engine=innodb;

create table questline(
	id int(11) NOT NULL AUTO_INCREMENT,
	strtitle varchar(20) NOT NULL,
    intformerquestline int(11) DEFAULT 0,
    fk_npc int(11) NOT NULL,
    primary key(id),
    foreign key(fk_npc) references npc(id)
)engine=innodb;

create table quest(
	id int(11) NOT NULL AUTO_INCREMENT,
	strtitle varchar(50) NOT NULL,
    intplayerxponcomplete int(11) DEFAULT 0,
    strquesttext text,
    intquestinline int(11) DEFAULT 0,
    fk_questline int(11) NOT NULL,
    primary key(id),
    foreign key(fk_questline) references questline(id)
)engine=innodb;

create table player(
	id int(11) NOT NULL AUTO_INCREMENT,
	strdisplayname varchar(20) NOT NULL,
    intlogout int(11) DEFAULT 0,
    strlanguage varchar(5),
    intsecuritylevel int(5) DEFAULT 1,
    stremail varchar(50) NOT NULL,
    strpassword varchar(255),
    intantikeylog varchar(255),
    intplayerlevel int(5) DEFAULT 1,
    intplayerxp int(11) DEFAULT 0,
    primary key(id)
)engine=innodb;

create table battlegroup(
	id int(11) NOT NULL AUTO_INCREMENT,
	strname varchar(20) NOT NULL,
    strshipname varchar(20),
    intincombat int(11) NOT NULL DEFAULT 0,
    colshipname varchar(11),
    intshipinternet int(5) DEFAULT 0,
    intshipcpu int(5) DEFAULT 0,
    fk_player int(11) NOT NULL,
    primary key(id),
    foreign key(fk_player) references player(id)
)engine=innodb;

create table role(
	id int(11) NOT NULL AUTO_INCREMENT,
    strname varchar(20),
    primary key(id)
)engine=innodb;

create table dayjob(
	id int(11) NOT NULL AUTO_INCREMENT,
    strname varchar(20),
    primary key(id)
)engine=innodb;

create table powerset(
	id int(11) NOT NULL AUTO_INCREMENT,
	strname varchar(20) NOT NULL,
    inttype int(5) DEFAULT 0,
    strimagepath varchar(50),
    straudiopath varchar(50),
    primary key(id)
)engine=innodb;

create table battlecharacter(
	id int(11) NOT NULL AUTO_INCREMENT,
	strname varchar(20) NOT NULL,
    intpowerlevel int(11) DEFAULT 100,
    intstrength int(5) DEFAULT 0,
    fk_role int(11) NOT NULL,
    fk_battlegroup int(11) NOT NULL,
    fk_dayjob int(11),
    fk_powerset int(11) NOT NULL,
    fk_secondarypowerset int(11) NOT NULL,
    primary key(id),
    foreign key(fk_role) references role(id),
    foreign key(fk_battlegroup) references battlegroup(id),
    foreign key(fk_dayjob) references dayjob(id),
    foreign key(fk_powerset) references powerset(id),
    foreign key(fk_secondarypowerset) references powerset(id)
)engine=innodb;

create table powers(
	id int(11) NOT NULL AUTO_INCREMENT,
    strname varchar(40),
	inttotaloutput int(11) DEFAULT 5,
    introunds int(5) DEFAULT 0,
    intcooldown int(5) DEFAULT 1,
    intcost int(5) DEFAULT 2,
    intthread int(5) DEFAULT 2,
    inttarget int(5) DEFAULT 0,
    fk_powerset int(11) NOT NULL,
    primary key(id),
    foreign key(fk_powerset) references powerset(id)
)engine=innodb;

create table enemy(
	id int(11) NOT NULL AUTO_INCREMENT,
	strname varchar(20) NOT NULL,
    inttype int(5) DEFAULT 0,
    intrank int(5) DEFAULT 0,
    primary key(id)
)engine=innodb;

create table battlequest(
	id int(11) NOT NULL AUTO_INCREMENT,
    fk_battlegroup int(11) NOT NULL,
    fk_quest int(11) NOT NULL,
    primary key(id),
    foreign key(fk_battlegroup) references battlegroup(id),
    foreign key(fk_quest) references quest(id)
)engine=innodb;

create table enemyofplanet(
	id int(11) NOT NULL AUTO_INCREMENT,
    fk_enemy int(11) NOT NULL,
    fk_planet int(11) NOT NULL,
    primary key(id),
    foreign key(fk_enemy) references enemy(id),
    foreign key(fk_planet) references planet(id)
)engine=innodb;

create table enemypowers(
	id int(11) NOT NULL AUTO_INCREMENT,
    fk_enemy int(11) NOT NULL,
    fk_powers int(11) NOT NULL,
    primary key(id),
    foreign key(fk_enemy) references enemy(id),
    foreign key(fk_powers) references powers(id)
)engine=innodb;

create table fight(
	id int(11) NOT NULL AUTO_INCREMENT,
    strname varchar(25) NOT NULL,
    intenemypowerlevel int(11) NOT NULL,
    primary key(id)
)engine=innodb;

create table battle(
	id int(11) NOT NULL AUTO_INCREMENT,
    fk_battlegroup int(11) NOT NULL,
    fk_fight int(11) NOT NULL,
    primary key(id),
    foreign key(fk_fight) references fight(id)
)engine=innodb;

create table battleenemy(
	id int(11) NOT NULL AUTO_INCREMENT,
    fk_fight int(11) NOT NULL,
    fk_enemy int(11) NOT NULL,
    primary key(id),
    foreign key(fk_fight) references fight(id),
    foreign key(fk_enemy) references enemy(id)
)engine=innodb;

create table battlestatsnapshot(
	fk_battle int(11) NOT NULL,
    fk_battlecharacter int(11) NOT NULL,
    intpowerlevel int(11) NOT NULL,
    inttalents int(11) NOT NULL,
    primary key(fk_battle,fk_battlecharacter),
    foreign key(fk_battle) references battle(id),
    foreign key(fk_battlecharacter) references battlecharacter(id)
)engine=innodb;

create table actions(
id int(11) NOT NULL AUTO_INCREMENT,
	fk_battle int(11) NOT NULL,
    playeractor int(11),
    playertarget int(11),
    fk_power int(11) NOT NULL,
    enemyactor int(11),
    enemytarget int(11),
    intmovex int(5) DEFAULT 0,
    intmovey int(5) DEFAULT 0,
    intdate int(11) NOT NULL,
    primary key(id),
    unique key(playeractor,enemyactor,intdate),
    foreign key(fk_battle) references battle(id),
    foreign key(playeractor) references battlecharacter(id),
    foreign key(playertarget) references battlecharacter(id),
    foreign key(fk_power) references powers(id),
    foreign key(enemyactor) references enemy(id),
    foreign key(enemytarget) references enemy(id)
)engine=innodb;

-- -----------------------------------------------------------------------------------------------------------------------------------------------------------------
-- TEST DATA--------------------------------------------------------------------------------------------------------------------------------------------------------
-- -----------------------------------------------------------------------------------------------------------------------------------------------------------------
insert into galaxy(strname) values ("TEST");

insert into solarsystem(strname,intpositionx,intpositiony,fk_galaxy) values
("SolarSystemTest 1",20,40,1),
("SolarSystemTest 2",80,60,1),
("SolarSystemTest 3",50,30,1);

insert into planet(strname,intposition,introtation,fk_solarsystem) values
("Planet 1",0,10,1),("Planet 2",1,20,1),("Planet 3",2,7,1),
("Planet 1",0,1,2),("Planet 2",1,15,2);

insert into npc(strname,fk_planet) values
("NPC",1),
("TEST",3),
("TEST 2",4);

insert into questline(strtitle,fk_npc) values ("The Questline",2);

insert into quest(strtitle,strquesttext,fk_questline) values ("The Quest","Go to Planet 1 in SolarSystem 2 to meed TEST 2",1);

insert into player(strdisplayname,strlanguage,intsecuritylevel,stremail,strpassword,intantikeylog) values
("Frk Bendiksen","da",0,"ckmb12@gmail.com","$2y$08$d.V/XpmXt.mqL.H7PnSKouk6jp6OypwceQfl3RV6SNQUfd/r2bbVO",""),
("TestPlayer","en",0,"a@a.a","$2y$15$uDcGbuowoB.JhcJeJ8wsW.D7CWEpVR0aLFPTg2XenJk3u4mzaBH6e","");

insert into battlegroup(strname,fk_player,intincombat) values ("BattleGroup 1",1,1),("BattleGroup 2",1,0);

insert into role(strname) values
("Tanker"),
("Supporter"),
("Healer"),
("Controller"),
("Damager");

insert into dayjob(strname) values ("Dayjob");

insert into powerset(strname) values
("Magma"),("Igniting"),("Warmth"),("Chaos"),("Solar"),
("Aquatic"),("Bubble Field"),("Pure Water"),("Dark Waters"),("Pressure"), 
("Infusion"),("Reflective"),("Angel"),("Solidify"),("Energy"),
("Stone"),("Crystal"),("Blood"),("Plant"),("Elemental"),
("Psy Shield"),("Alteration"),("Mind Cure"),("Illusion"),("Shadow"),
("Freezing"),("Arctic"),("Cold"),("Storm"),("Cryo");

insert into battlecharacter(strname,fk_role,fk_battlegroup,fk_powerset,fk_secondarypowerset) values
("FireThing",4,1,1,5),("IceThing",1,1,6,4),("LightThing",5,1,3,2),
("FireThing",5,2,1,2),("IceThing",2,2,6,5),("LightThing",3,2,3,4);

insert into powers(strname,fk_powerset,inttotaloutput,introunds,intcooldown,intcost,intthread) values
("MagmaAbsorb",			1,	0,0,1,2,5),
("IgnitingBuff",		2,	5,0,1,3,10),
("WarmthHeal",			3,	-5,0,1,3,10),
("ChaosGenerator",		4,	5,0,1,2,2),
("SolarBeam",			5,	15,0,1,5,15),
("AquaticHeal",			6,	-15,0,1,10,12),
("Bubble Shielding",            7,	5,0,1,2,2),
("Pure Water Heal",		8,	5,0,1,2,2),
("Dark Waters Hold",            9,	5,0,1,2,2),
("Pressure Building",           10,	5,0,1,2,2),
("Infusion Regenerade",         11,	5,0,1,2,2),
("Reflective Shield",           12,	5,0,1,2,2),
("Angelic Heal", 		13,	5,0,1,2,2),
("Solidify Hold",		14,	5,0,1,2,2),
("Energy Beam",			15,	5,0,1,2,2),
("Stone Harden",		16,	5,0,1,2,2),
("Crystal Buff",		17,	5,0,1,2,2),
("Blood Transfusion",           18,	5,0,1,2,2),
("Plant Hold",          	19,	5,0,1,2,2),
("Elemental Powerup",           20,	5,0,1,2,2),
("Psy Shield Mind over Body",   21,     5,0,1,2,2),
("Alteration Transform",        22,     5,0,1,2,2),
("Mind Cure Heal",		23,	5,0,1,2,2),
("Illusion Confuse",            24,	5,0,1,2,2),
("Shadow Haunt",		25,	5,0,1,2,2),
("Freezing Ice Block",          26,	5,0,1,2,2),
("Arctic Buff",			27,	5,0,1,2,2),
("Cold Heal",			28,	5,0,1,2,2),
("Storm Lightning",		29,	5,0,1,2,2),
("Cryo Freeze",			30,	5,0,1,2,2);

insert into enemy(strname) values
("FireEnemy"),
("WaterEnemy"),
("LightEnemy");

insert into battlequest(fk_battlegroup,fk_quest) values
(1,1),
(2,1);

insert into enemyofplanet(fk_enemy,fk_planet) values
(1,1),(1,2),(1,3),
(2,2),(2,3),(2,4),
(3,3),(3,4),(3,5);

insert into enemypowers(fk_enemy,fk_powers) values
(1,1),(1,5),
(2,2),
(3,3);

insert into fight(strname,intenemypowerlevel) values
('Fire and Water',10),
('Fire and Light',20);

insert into battle(fk_battlegroup,fk_fight) values (1,1);

insert into battleenemy(fk_fight,fk_enemy) values
(1,1),(1,2),
(2,1),(2,3);

insert into battlestatsnapshot (fk_battle,fk_battlecharacter,intpowerlevel,inttalents) value
(1,1,1500,0),(1,2,1000,0),(1,3,1000,0); 

-- player attack
insert into actions(fk_battle,playeractor,fk_power,enemytarget,intmovex,intmovey,intdate) values (1,1,5,1,2,2,UNIX_TIMESTAMP(NOW()));

-- enemy attack
insert into actions(fk_battle,playertarget,fk_power,enemyactor,intmovex,intmovey,intdate) values (1,1,5,1,8,2,UNIX_TIMESTAMP(NOW()));

-- player heal
insert into actions(fk_battle,playeractor,playertarget,fk_power,intmovex,intmovey,intdate) values (1,2,1,6,3,7,UNIX_TIMESTAMP(NOW()));

-- set foreign_key_checks = 1;