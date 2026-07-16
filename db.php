<?php
// Prevent direct access to db.php
if (basename($_SERVER['PHP_SELF']) == 'db.php') {
    header("HTTP/1.1 403 Forbidden");
    exit("Access Denied");
}

define('DB_FILE', __DIR__ . '/database.json');

function init_db() {
    if (!file_exists(DB_FILE)) {
        $default_data = [
            'notices' => [
                [
                    'id' => 1,
                    'title' => 'Internal Exam Schedule',
                    'desc' => 'Internal examinations will be held from 20th July 2026. Please check the timetable.',
                    'author' => 'Prof. Rajesh Sharma',
                    'role' => 'Faculty',
                    'date' => '15 Jul 2026 10:30 AM',
                    'attachment' => 'schedule.pdf',
                    'size' => '245 KB'
                ],
                [
                    'id' => 2,
                    'title' => 'Project Submission',
                    'desc' => 'Final year project reports to be submitted by 5th August 2026.',
                    'author' => 'Prof. Neha Patil',
                    'role' => 'Faculty',
                    'date' => '14 Jul 2026 02:15 PM',
                    'attachment' => 'guidelines.docx',
                    'size' => '512 KB'
                ],
                [
                    'id' => 3,
                    'title' => 'Holiday Notice',
                    'desc' => 'College will remain closed on 18th July 2026 on account of Muharram.',
                    'author' => 'Admin Office',
                    'role' => 'Administration',
                    'date' => '12 Jul 2026 09:00 AM',
                    'attachment' => '',
                    'size' => ''
                ],
                [
                    'id' => 4,
                    'title' => 'Lab Maintenance',
                    'desc' => 'Computer Lab 2 will be under maintenance on 16th July 2026.',
                    'author' => 'Prof. Amit Deshmukh',
                    'role' => 'Faculty',
                    'date' => '10 Jul 2026 04:45 PM',
                    'attachment' => '',
                    'size' => ''
                ],
                [
                    'id' => 5,
                    'title' => 'Seminar on AI',
                    'desc' => 'Seminar on "Introduction to Artificial Intelligence" on 25th July 2026.',
                    'author' => 'Prof. Priya Kulkarni',
                    'role' => 'Faculty',
                    'date' => '08 Jul 2026 11:20 AM',
                    'attachment' => 'seminar.pdf',
                    'size' => '380 KB'
                ]
            ],
            'assignments' => [
                [
                    'unit' => 1,
                    'title' => 'Unit 1 - Introduction to Basics',
                    'desc' => 'Solve all the questions given in the assignment.',
                    'due' => '25 Jul 2026 11:59 PM',
                    'status' => 'graded',
                    'file' => 'assignment_1_prasad.pdf',
                    'marks' => '7 / 10'
                ],
                [
                    'unit' => 2,
                    'title' => 'Unit 2 - Data Structures',
                    'desc' => 'Answer all questions in detail.',
                    'due' => '08 Aug 2026 11:59 PM',
                    'status' => 'graded',
                    'file' => 'assignment_2_final.pdf',
                    'marks' => '10 / 10'
                ],
                [
                    'unit' => 3,
                    'title' => 'Unit 3 - Object Oriented Programming',
                    'desc' => 'Complete the assignment as per instructions.',
                    'due' => '22 Aug 2026 11:59 PM',
                    'status' => 'pending',
                    'file' => '',
                    'marks' => 'Pending'
                ],
                [
                    'unit' => 4,
                    'title' => 'Unit 4 - Database Management Systems',
                    'desc' => 'Submit all the questions.',
                    'due' => '05 Sep 2026 11:59 PM',
                    'status' => 'pending',
                    'file' => '',
                    'marks' => 'Pending'
                ],
                [
                    'unit' => 5,
                    'title' => 'Unit 5 - Operating Systems',
                    'desc' => 'Answer the given questions.',
                    'due' => '20 Sep 2026 11:59 PM',
                    'status' => 'pending',
                    'file' => '',
                    'marks' => 'Pending'
                ],
                [
                    'unit' => 6,
                    'title' => 'Unit 6 - Computer Networks',
                    'desc' => 'Complete and submit the assignment.',
                    'due' => '05 Oct 2026 11:59 PM',
                    'status' => 'pending',
                    'file' => '',
                    'marks' => 'Pending'
                ]
            ],
            'leaves' => [
                [
                    'id' => 1,
                    'file' => 'Leave_Form_15_Jan_2026.pdf',
                    'reason' => 'Medical',
                    'from' => '15 Jan 2026',
                    'to' => '17 Jan 2026',
                    'status' => 'Approved'
                ],
                [
                    'id' => 2,
                    'file' => 'Leave_Form_02_Feb_2026.docx',
                    'reason' => 'Personal',
                    'from' => '02 Feb 2026',
                    'to' => '03 Feb 2026',
                    'status' => 'Pending'
                ],
                [
                    'id' => 3,
                    'file' => 'Leave_Form_10_Mar_2026.pdf',
                    'reason' => 'Family Function',
                    'from' => '10 Mar 2026',
                    'to' => '11 Mar 2026',
                    'status' => 'Approved'
                ],
                [
                    'id' => 4,
                    'file' => 'Leave_Form_21_Apr_2026.docx',
                    'reason' => 'Medical',
                    'from' => '21 Apr 2026',
                    'to' => '23 Apr 2026',
                    'status' => 'Rejected'
                ],
                [
                    'id' => 5,
                    'file' => 'Leave_Form_05_May_2026.pdf',
                    'reason' => 'Exam Preparation',
                    'from' => '05 May 2026',
                    'to' => '07 May 2026',
                    'status' => 'Pending'
                ]
            ]
        ];
        file_put_contents(DB_FILE, json_encode($default_data, JSON_PRETTY_PRINT));
    }
}

function get_db() {
    init_db();
    return json_decode(file_get_contents(DB_FILE), true);
}

function save_db($data) {
    file_put_contents(DB_FILE, json_encode($data, JSON_PRETTY_PRINT));
}
?>
