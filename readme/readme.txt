1. Get Test 
	URL:	http://192.168.1.21/nowitest/api/test/index.php/getAllTest
	Params:	
			ismobile:1
			course:14
			userid:7
	Success Response:
		 {"status":200,"records found":[{"test_id":"2","title":"Sales marketing paper 	2","course":"14","subject":"104","test_time":"100","created_at":"2016-08-23 18:12:22","updated_at":"2016-08-24 10:22:57","isEnabled":"1","isDeleted":"0"},{"test_id":"3","title":"Sales marketing paper 1","course":"14","subject":"104","test_time":"100","created_at":"2016-08-23 19:03:01","updated_at":"2016-08-24 10:22:47","isEnabled":"1","isDeleted":"0"}]}
	 
	 Fail Response
	 	 {"status":400,"records found":[]}

2. Validate Code
	URL:	http://192.168.1.21/nowitest/api/test/index.php/validateCode
	Params:
		ismobile:1
		code:cdtsky
		test_id:2
	Success Response:
		 {"status":200,"message":"Code validated"}
	Fail Response:
		 {"status":400,"message":"Invalid code"}


3. Get Test Questions
	URL:	http://192.168.1.21/nowitest/api/question/index.php/getQuestions
	Params:
		ismobile:1
		test_id:3
	Success Response:
		 {"status":200,"data":[{"question_id":"39","test_id":"4","question":"What is session.?","options":[{"choice_id":"17","choice":"session is server side variable","is_file":"0","is_right":"1"},{"choice_id":"18","choice":"session is server client side variable","is_file":"0","is_right":"0"},{"choice_id":"19","choice":"session is local constants","is_file":"0","is_right":"0"},{"choice_id":"20","choice":"Hypertext Preprocessor.","is_file":"0","is_right":"0"}]},{"question_id":"40","test_id":"4","question":"What is php?","options":[{"choice_id":"21","choice":"Personal Home page","is_file":"0","is_right":"1"},{"choice_id":"22","choice":"Pre hypertext markup Language","is_file":"0","is_right":"0"},{"choice_id":"23","choice":"PHP prehypertext markup","is_file":"0","is_right":"0"},{"choice_id":"24","choice":"Hypertext Preprocessor.","is_file":"0","is_right":"0"}]},{"question_id":"41","test_id":"4","question":"How to set session in php.?","options":[{"choice_id":"25","choice":"$_SESSION()=$VALUE","is_file":"0","is_right":"0"},{"choice_id":"26","choice":"$_SESSION['username']='abc'","is_file":"0","is_right":"1"},{"choice_id":"27","choice":"$_session(username)=avc","is_file":"0","is_right":"0"},{"choice_id":"28","choice":"$_session=avc","is_file":"0","is_right":"0"}]}]}

	Fail Response:
		 {"status":400,"data":"Invalid Data"}


Date 25-8-16


4. Student Login. 

	URL:	http://192.168.1.21/nowitest/api/student/index.php/signIn
	Params:	
		ismobile:1
		email:abhinay@test.com
		password:asdasd
	Success Response:
		 {"status":200,"data":[{"student_id":"6","first_name":"Abhinay","last_name":"Phuke","photo":"Adinath-Kothare-childhood-photo-200x200.jpg","address":"warje pune","email":"abhinay@test.com","phone":"9673012454","course":"14","attendance":"10","password":"1mU3uHtjd5qyLymKQxp6__iUaWK13HncwJsCD7ZYorg","created_at":"2016-08-24 16:16:13","updated_at":"2016-08-24 16:16:13","isEnabled":"1","isDeleted":"0"}]}

	Fail Response:
		 {"status":400,"data":[]}

5. Admin Login
	URL:	http://192.168.1.21/nowitest/api/admin/index.php/signin
	Params:
		username:superadmin@quiz.com
		password:asd
		ismobile:1
	Success Response:
		  {"status":200,"data":[{"id":"10","regId":"","name":"Super Admin Star","address":"NA","city":"NA","mobile":"9860150435","created_at":"2015-11-05 17:09:17","modify_at":"2015-11-05 17:09:17","status":"1","user_type":"1","email":"superadmin@quiz.com","password":"pC9bx7sXEbBnBwmXBuWFiHCjPezaUFl4WsgEYuaRDKc","image":"NA"}]}
	Fail response:
	 	 {"status":400,"data":[]}

6. Submit test API:-
http://192.168.1.21/nowitest/api/test/index.php/submitTest
test_id:8
data:[{
	"question_id": "49",
	"question_marks": "34",
	"time_taken": "0:0:5",
	"user_choice": "57",
	"correct_answer": "57"
}, {
	"question_id": "46",
	"question_marks": "34",
	"time_taken": "0:0:9",
	"user_choice": "45,46",
	"correct_answer": "46"
}, {
	"question_id": "47",
	"question_marks": "34",
	"time_taken": "0:0:2",
	"user_choice": "50,51",
	"correct_answer": "50"
}, {
	"question_id": "45",
	"question_marks": "34",
	"time_taken": "0:0:2",
	"user_choice": "41,42",
	"correct_answer": "44"
}, {
	"question_id": "48",
	"question_marks": "34",
	"time_taken": "0:0:2",
	"user_choice": "56",
	"correct_answer": "56"
}, {
	"question_id": "43",
	"question_marks": "34",
	"time_taken": "0:0:10",
	"user_choice": "33,34",
	"correct_answer": "36"
}, {
	"question_id": "44",
	"question_marks": "34",
	"time_taken": "0:0:13",
	"user_choice": "37",
	"correct_answer": "38,39"
}]
userid:7


7.User attempted test
		URL:-	http://192.168.1.21/nowitest/api/test/index.php/studentAttemptedTest
		Params:-
			ismobile:1
			userid:7



8. User analytics
	a.For specific test
		URL:	http://192.168.1.21/nowitest/api/test/index.php/getAnalytics
		Params:-	
			test_id:5
			userid:7
	b. Overall analytics
		URL:	http://192.168.1.21/nowitest/api/test/index.php/getAnalytics
		Params:-	
			test_id:0
			userid:7
9. subject of courses API.
		URL:	http://192.168.1.21/nowitest/api/sub/index.php/getCourseSubList
		Params:	
			ismobile:1
			course:1

		Success Response:
			 {"status":200,"data":[{"cat_id":"104","cat_name":"PHP","course":"14,1","syllabus":"90787-sample (copy).pdf","parent_id":"0","level":"0","isEnabled":"1","created_at":"2016-08-22 10:54:47","updated_at":"2016-09-09 17:17:34","isDeleted":"0"},{"cat_id":"105","cat_name":"Finance account","course":"13,1","syllabus":"81016-sample (another copy).pdf","parent_id":"0","level":"0","isEnabled":"1","created_at":"2016-08-22 10:55:06","updated_at":"2016-09-09 17:17:28","isDeleted":"0"}]}
		Fail Response:
			 {"status":400,"data":[]} {"status":400,"data":[]}

10. Subject PDF API
		URL:	http://192.168.1.21/nowitest/api/sub/index.php/getSubjPdf
		Params:
			ismobile:1
			subject:104
		Success Response:-
			 {"status":200,"data":[{"syllabus":"89415-sample_(another_copy).pdf"}]}
		Fail Response:-
			 {"status":400,"data":[]}

11. TopWaiting time API
	a.specific test analytics:-	
		URL:	http://192.168.1.21/nowitest/api/test/index.php/getTopWaiting
		Params:	
			test_id:4
			userid:7
			ismobile:1
		Success Response:-
			{"status":200,"data":[{"question":"Q-4","timetaken":"00:00:05"},{"question":"Q-6","timetaken":"00:00:04"},{"question":"Q-7","timetaken":"00:00:03"},{"question":"Q-1","timetaken":"00:00:03"},{"question":"Q-5","timetaken":"00:00:03"}]}
	
	b.Overall test analytics:-
		URL:	http://192.168.1.21/nowitest/api/test/index.php/getTopWaiting
		Params:	
			test_id:0
			userid:7
			ismobile:1
		Success Response:-
			{"status":200,"data":[{"question":"Test-Sales marketing paper 2 : Q-2","timetaken":"00:00:36"},{"question":"Test-Sales marketing paper 2 : Q-1","timetaken":"00:00:08"},{"question":"Test-PHP test : Q-4","timetaken":"00:00:05"},{"question":"Test-PHP test : Q-6","timetaken":"00:00:04"},{"question":"Test-Sales marketing paper 2 : Q-3","timetaken":"00:00:03"}]}


12. Syllabus PDF API
		URL:	http://192.168.1.21/nowitest/api/syllabus/index.php/getSyllabusPdf
		Params:
			ismobile:1
			course:14
		Success Response:-
			 {"status":200,"data":[{"id":"19","syllabus_id":"6","file_name":"8616-sample_(3rd_copy).pdf","path":"http:\/\/192.168.1.21\/nowitest\/uploads\/syllabus\/8616-sample_(3rd_copy).pdf"},{"id":"18","syllabus_id":"6","file_name":"48865-Mobintia-ListofHolidays-2016.pdf","path":"http:\/\/192.168.1.21\/nowitest\/uploads\/syllabus\/48865-Mobintia-ListofHolidays-2016.pdf"},{"id":"10","syllabus_id":"4","file_name":"85389-syllabus","path":"http:\/\/192.168.1.21\/nowitest\/uploads\/syllabus\/85389-syllabus"}]}
		Fail Response:-
			 {"status":400,"data":[]}

13. Get notice for course API
		URL:	http://192.168.1.21/nowitest/api/notice/index.php/getNotice
		Params:	
			ismobile:1
			course:14
		Success Response:-
			 {"status":200,"data":[{"notice_id":"7","course":"0","title":"All notice","notice":"This notice for all.","created_at":"2016-09-21 15:49:50","updated_at":"2016-09-21 15:49:50","isEnabled":"1"},{"notice_id":"8","course":"14","title":"marketing notice","notice":"This is notice for marketing.","created_at":"2016-09-21 16:02:09","updated_at":"2016-09-21 16:03:07","isEnabled":"1"}]}

14. Get flashcard pdf API
		URL:	http://192.168.1.21/nowitest/api/flashcard/index.php/getFlashCardPdf
		Params:
			ismobile:1
			course:13
		Success Response:-
			{"status":200,"data":[{"id":"15","flashcard_id":"20","file_name":"73135-YoGrocer_Mobile_Application_Specification_Document_V6.pdf","path":"http:\/\/192.168.0.104\/nowitest\/uploads\/Flashcard\/73135-YoGrocer_Mobile_Application_Specification_Document_V6.pdf"},{"id":"13","flashcard_id":"20","file_name":"92213-sample.pdf","path":"http:\/\/192.168.1.21\/nowitest\/uploads\/Flashcard\/92213-sample.pdf"}]}
		Fail Response:-
			 {"status":400,"data":[]}

