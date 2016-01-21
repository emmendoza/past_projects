db2 disconnect cs174
db2 drop database cs174
db2 create database cs174
db2 connect to cs174
db2 "create bufferpool bp8k pagesize 8 k"
db2 "create system temporary tablespace tmpsys8k pagesize 8 k bufferpool bp8k"
db2se enable_db cs174
db2 create table school (name1 varchar(30),name2 varchar(30),street varchar (40),city varchar (40),state char(2),zip char(5),county varchar(40),long decfloat,lat decfloat,location db2gse.ST_POINT)
db2 create table restaurant (name1 varchar(30),name2 varchar(30),street varchar (40),city varchar (40),state char(2),zip char(5),county varchar(40),long decfloat,lat decfloat,location db2gse.ST_POINT)
db2 import from project1schools.csv of del insert into school (name1,name2,street,city,state,zip,county,long,lat)
db2 update school set location = db2gse.ST_Point(long, lat, 1)
db2 import from project1restaurants.csv of del insert into restaurant (name1,name2,street,city,state,zip,county,long,lat)
db2 update restaurant set location = db2gse.ST_Point(long, lat, 1)