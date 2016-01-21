Windows machine setup (*.bat file used)

To instantiate the database, open up db2 command line as administrator(RIGHT CLICK AND RUN IN ADMINISTRATOR MODE AS WELL) and navigate to this directory.
Type 'createAndPopulate.bat' into the new window and hit enter.
You should see db2 slowly creating the database, line by line.

I attached a picture of what this prototype database schema looks like
Check it out before proceeding to the commands below

//start
db2 connect to mysjsu

//returns all classes taken by student 1 (Adam Anderson)
db2 select cid from classestaken where sid ='1' order by cid

//returns the prereq course from course 3 (Math 3)
db2 select pRcid from course where cid ='3'

// checks if student 1 has taken course 5
db2 select cid from classestaken where sid ='1' and cid = '5'

// checks if student 2 (Ben Bernard) has taken the pre req for course 3
//should return 0 matches

db2 select cid from classestaken where sid ='2' and cid = (select pRcid from course where cid ='3')

// checks if student 1 (Adam Anderson) has taken the pre req for course 6
//should return 1 match with course cid.

db2 select cid from classestaken where sid ='1' and cid = (select pRcid from course where cid ='6')
