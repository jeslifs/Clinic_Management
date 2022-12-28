# Clinic_Management
DBMS project

Languages used are php,css,html.

Here a patient can register or login and take an appointment with a specific doctor, the docotr will see only those patient who has appointment with him.

The nurse can delete the appointment of the patient, The nurse can see all the appointments. I have used limt here so the nurse can see only 5 appointments at a time
and can click on next to see the remaining appointments.

Session are used once the patient, nurse, doctor logsin welcome page will be displayed saying welcome[username]

For the serverside php is been used,sql queries like aggrigate, limit, triggers, views, joins are been used.





Here the code for creating the database:

Create database:
create database clinic_management;


Create tables:

create table Patient(
	P_id int(20) PRIMARY key AUTO_INCREMENT,
    F_name varchar(50),
    M_name varchar(50),
    L_name varchar(50),
    Sex varchar(10),
    Address varchar(255),
    Dob date
)engine=INNODB;


create table Appointment(
	A_id int(20) primary key AUTO_INCREMENT,
    N_id int(20),
    D_id int(20),
    A_date date,
    A_time time
)ENGINE=INNODB;

create table Nurse(
	N_id int(20) primary key AUTO_INCREMENT,
    F_name varchar(50),
    M_name varchar(50),
    L_name varchar(50),
    Experience int(20)
)engine=innodb;




create table Doctor(
	D_id int(20) primary key AUTO_INCREMENT,
    N_id int(20),
    F_name varchar(50),
    M_name varchar(50),
    L_name varchar(50),
    Qualification varchar(70),
    Experience int(20),
    S_id int(20)
)engine=INNODB;



create table Appointment_taken(
	P_id int(20),
    A_id int(20)
)engine=innodb;

create table Patient_history(
	P_id int(20),
    P_history varchar(255)
)engine=innodb;


create table Appoint_reason(
	A_id int(20),
    Reason varchar(255)
)engine=innodb;



create table Specialization_doc(
	S_id int(20),
    Specialization varchar(50)
)engine=innodb;

Alter

alter table appointment_taken
add foreign KEY(P_id) REFERENCES patient(P_id)


alter table appointment_taken
add foreign KEY(A_id) REFERENCES appointment(A_id)


alter table patient_history
add foreign KEY(P_id) REFERENCES patient(P_id)


alter table appoint_reason
add foreign KEY(A_id) REFERENCES appointment(A_id)


alter table doctor
add foreign KEY(S_id) REFERENCES specialization_doc(S_id)



alter table doctor
add foreign KEY(N_id) REFERENCES nurse(N_id)


alter table appointment
add foreign KEY(N_id) REFERENCES nurse(N_id)


alter table appointment
add foreign KEY(D_id) REFERENCES doctor(D_id)




View: doc_patient

create view doc_patient AS
SELECT patient.P_id, patient.F_name, appointment.D_id,appointment.A_date,appointment.A_time,doctor.DF_name
from patient,appointment,doctor
where patient.P_id=appointment.A_id and appointment.D_id=doctor.D_id





Trigger:paitent

CREATE trigger p_age before insert on patient
for each row 
insert into patient_age
set action="insert",
id=new.P_id,
P_age=year(CURRENT_DATE)-year(`Dob`);




DELIMITER $$
CREATE trigger after_insert_users
after insert on users
for each ROW
BEGIN
	INSERT INTO `users_backup`(`uid`, `u_userame`, `u_password`, `U_type`) VALUES (new.'uid',new.'u_userame',new.'u_password',new.'U_type');
    
END $$ 
DELIMITER ;





Inner join:Nurse



SELECT a.`A_id`,a.`A_date`,a.`A_time`,ar.Reason ,d.DF_name
FROM `appointment` as a 
inner join appoint_reason as ar 
inner join doctor as d
WHERE a.A_id=ar.A_id and a.`D_id`=d.D_id;


Joins appointment taken, appointment reason and doctor





 Inner join:Doctor

SELECT dp.P_id,dp.F_name,ph.P_history,dp.A_date,dp.A_time FROM `doc_patient` as dp INNER join patient_history as ph WHERE dp.P_id=ph.P_id and dp.DF_name='William';

Joins doc_patient and patient_history 

