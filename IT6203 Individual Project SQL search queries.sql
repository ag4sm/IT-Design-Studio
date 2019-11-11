Query to select Name, email and services offered:

 select profiles.fname, lname, email, services.service 
 from profiles, services, services_provided 
 where profiles.profileID = services_provided.profileID AND services_provided.serviceID = services.serviceID AND profiles.profileID = 3;
 
 Query to show services selected to offer:
 
 select services.service 
 from profiles, services, services_provided
 where profiles.profileID = services_provided.profileID AND services_provided.serviceID = services.serviceID AND profiles.profileID = 3;
 
 Same as above, but adds days and times: 
 
 select services.service, days.days, timeslots.timeslot 
 from profiles, services, services_provided, days, days_provided, timeslots, timeslots_provided 
 where profiles.profileID = services_provided.profileID AND services_provided.serviceID = services.serviceID AND profiles.profileID = days_provided.profileID AND days_provided.dayID = days.dayID AND profiles.profileID = timeslots_provided.profileID AND profiles.profileID = 3 group by services_provided.profileID;
 
Query to select services on a last name search result:
 
 select profiles.profileID, services.service, services_provided.serviceID from profiles, services, services_provided where services_provided.serviceID = services.serviceID AND profiles.profileID = services_provided.profileID AND profiles.lname = 'Clay';

Query to display entered services:
 
 select services_provided.profileID, services_provided.serviceID, services.serviceID, service
 from services, services_provided 
 where services_provided.serviceID = services.serviceID 
 AND services_provided.profileID = $last_entered_ID;
 
 
 
 
search for services on search page:  Who provides the searched service?  Give me their first name, last name and email address.
 
select fname, lname, email, services.service from profiles, services inner join services_provided where profiles.profileID = services_provided.profileID AND services_provided.serviceID = services.serviceID AND services.service ='$_POST[searchservice]';

Query above, but adding days available and times available: 

select profiles.fname, profiles.lname, profiles.email, services.service, days.days, timeslots.timeslot FROM profiles INNER JOIN services_provided on profiles.profileID = services_provided.profileID 
INNER JOIN services on services_provided.serviceID = services.serviceID 
INNER JOIN days_provided on profiles.profileID = days_provided.profileID
INNER JOIN days on days_provided.dayID = days.dayID
INNER JOIN timeslots_provided on profiles.profileID = timeslots_provided.profileID
INNER JOIN timeslots on timeslots_provided.timeID = timeslots.timeID 
where services.service = 'Javascript';

select days_provided.profileID, days.days from days_provided inner join days on days_provided.dayID = days.dayID;
(select services_provided.profileID, services.service from services_provided inner join services on services_provided.serviceID = services.serviceID;)













