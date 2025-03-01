/*
CREATE TABLE questions (
  question_id     INT           NOT NULL,
  question        TEXT          NOT NULL,
  name            VARCHAR(100)  NOT NULL,
  institute       VARCHAR(100)  NOT NULL,
  submitted_at    TIMESTAMP     DEFAULT CURRENT_TIME,
  PRIMARY KEY(question_id)
);



CREATE TABLE moderator (
  mod_id      INT           AUTO_INCREMENT,
  mod_name    VARCHAR(20),
  PRIMARY KEY (mod_id)
);


CREATE TABLE code (
  code_id    INT         AUTO_INCREMENT,
  code      VARCHAR(16) NOT NULL,
  PRIMARY KEY (code_id)
);


*/ 

INSERT INTO questions (question, name, institute) VALUES
('What is the role of youth in governance?', 'John Doe', 'University of Nairobi'),
('How can we improve mental health awareness in schools?', 'Jane Smith', 'Kenyatta University'),
('What are the best ways to engage MPs on public finance issues?', 'Michael Otieno', 'The Cooperative University of Kenya'),
('How does social media impact youth participation in politics?', 'Emily Wangari', 'Strathmore University'),
('What strategies can be used to tackle unemployment among the youth?', 'David Mwangi', 'JKUAT'),
('How can we ensure transparency in government spending?', 'Alice Kimani', 'Daystar University'),
('What policies should be introduced to support young entrepreneurs?', 'Kevin Ochieng', 'Multimedia University'),
('How can we promote digital literacy among young people?', 'Susan Achieng', 'USIU'),
('What challenges do young women face in leadership, and how can we address them?', 'Brenda Njeri', 'Egerton University'),
('Should university education be made free for all?', 'Daniel Okello', 'Maseno University');


/*
DELETE FROM questions;
SELECT * FROM questions;

DELETE FROM questions;

SELECT * FROM questions;
*/




/*
ALTER TABLE code
MODIFY COLUMN code VARCHAR(16);

INSERT INTO code (code) VALUES ("AYLFKENYA_QA");

SELECT * FROM code;
*/ 


