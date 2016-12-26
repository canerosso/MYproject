<?php

# --- URL SETTINGS ---	
//define('URL', "http://localhost/nowitest/");	
//define('URL', "http://192.168.0.101/nowitest/");	
define('URL', "http://192.168.1.21/nowitest/");	


define('SUPERADMINSTAR', '1'); //user:mobintia_utsav_a, db:mobintia_utsav
define('SUPERADMIN', '2'); 
define('ADMIN', '3');
define('VENDOR', '4');
define('USER', '0');

# --- Server Database Connection ---

define('SERVER_DB_USERNAME', 'root'); //user:mobintia_utsav_a, db:mobintia_utsav
define('SERVER_DB_PASSWORD', 'root'); 
define('SERVER_DB_HOST', 'localhost');
define('SERVER_DB_NAME', 'nowItest');
define('SERVER_API_KEY', 145236);
define('PUBLIC_KEY', 'Lu70K$i3pu5xf7*I8tNmd@x2oODwwDRr4&xjuyTh');
define('GOOGLE_PUSH_API_KEY', 'AIzaSyARPIBI_AGSv023uE65wQ8NAMCtAmVoBR4');


# --- Table ---


define('TABLE_USER', '`users`');
define('TABLE_CAT', '`category_management`');
define('TABLE_QUE', '`questions`');
define('TABLE_QUE_CH', '`question_choices`');
define('TABLE_FIELD', '`field`');
define('TABLE_COURSE', '`course`');
define('TABLE_INSTITUTE', '`institute`');
define('TABLE_TEACHER', '`teacher`');
define('TABLE_TEST', '`test`');
define('TABLE_QUESTION', '`question`');
define('TABLE_STUDENT', '`student`');
define('TABLE_CHOICE', '`question_choices`');
define('TABLE_TESTRESULT', '`test_result`');
define('TABLE_TESTRESULTOPT', '`test_result_options`');
define('TABLE_SUBPDF', '`subject_pdf`');
define('TABLE_FLASH', '`flashcard`');
define('TABLE_FLASH_DATA', '`flashcard_data`');
define('TABLE_SYLLABUS', '`syllabus`');
define('TABLE_SYLLABUS_DATA', '`syllabus_data`');
define('TABLE_NOTICE', '`notice`');


# ---  Response Status ---

define('TAG_RESPONSE_SUCCESS', 200);
define('TAG_RESPONSE_BAD', 400);
define('TAG_RESPONSE_NO_DATA', 500);
define('TAG_STATUS_FAIL', -1);
define('TAG_RESPONSE_FAIL', 400);
define('TAG_NOT_ACCEPTABLE', 406);
define('TAG_UNAUTHORIZE', 401);


# ---  HTTP Response Code Status ---
define('TAG_RESPONSE_OK', 200);
define('TAG_RESPONSE_CREATED', 201);
define('TAG_RESPONSE_ACCEPTED', 202);
define('TAG_RESPONSE_NO_CONTENT', 204);

define('TAG_RESPONSE_MOVED_PERMENTATLY', 301);
define('TAG_RESPONSE_FOUND', 302);
define('TAG_RESPONSE_NOT_MODIFIED', 304);
define('TAG_RESPONSE_TEMPORARY_REDIRECT', 307);

define('TAG_RESPONSE_UNAUTHORIZED', 401);
define('TAG_RESPONSE_PAYMENT_REQUIRED', 402);
define('TAG_RESPONSE_NOT_FOUND', 404);
define('TAG_RESPONSE_METHOD_NOT_ALLOWED', 405);
define('TAG_RESPONSE_METHOD_NOT_ACCEPTABLE', 406);
define('TAG_RESPONSE_REQUEST_TIME_OUT', 408);

define('TAG_RESPONSE_SERVER_ERROR', 301);
define('TAG_RESPONSE_NOT_IMPLEMENTED', 302);
define('TAG_RESPONSE_SERVICE_UNAVIALBALE', 304);

# ---  Status Flags ---
define('TAG_STATUS', "status");
define('TAG_MESSAGE', "message");
define('TAG_COUNT', "count");
define('TAG_RECORD_FOUND', "records found");
define('TAG_NO_RECORD_FOUND', "no records found");
define('TAG_API_ERROR_MESSAGE', "invalid server api key");
define('TAG_API_ERROR_MESSAGE_MOBILE', "invalid mobile");
define('TAG_API_ERROR_MESSAGE_1', "image upload error");
define('TAG_API_SUCCESS_MESSAGE', "success");
define('TAG_PASSWORD_OR_MAIL_NOT_MATCH', "Password or email not match");


# ---  JSON TAG ---


define('IMAGE_UPLOAD_DIRECTORY', "images");
define('IMAGE_THUMB_DIRECTORY', "images");
define('IMAGE_UPLOAD_PATH', "superadmin");
define('ADMIN_IMAGE_UPLOAD_PATH', "admin");

define('TAG_FILE_NOT_IMG',"File is not an image");
define('TAG_ALREADY_EXISTS',"Sorry, file already exists");
define('TAG_TOO_LARGE',"Sorry, your file is too large");
define('TAG_FILETYPE_NOT_ALLOW',"File Type Not Allowed");
define("DOC_URL",$_SERVER['DOCUMENT_ROOT']."/nowitest/");

?>