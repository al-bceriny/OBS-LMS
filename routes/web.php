<?php
// NAME SPACES
    //  { I used "as" to more explain and be more simple to understand}
    use App\Http\Controllers\Student\GradeController as StudentGradeController;
    use App\Http\Controllers\Student\AttendanceController as StudentAttendanceController;
    use App\Http\Controllers\Student\ExamController as StudentExamController;
    use App\Http\Controllers\Teacher\EnrollmentController as TeacherEnrollmentController;
    use App\Http\Controllers\Student\EnrollmentController as StudentEnrollmentController;
    use App\Http\Controllers\Teacher\ExamResultController;
    use App\Http\Controllers\Teacher\ExamController;
    use App\Http\Controllers\Teacher\SubmissionController;
    use App\Http\Controllers\Teacher\AssignmentController;
    use App\Http\Controllers\Student\AssignmentSubmissionController;
    use App\Http\Controllers\Teacher\TeacherCourseController;
    use App\Http\Controllers\Teacher\MaterialController;
    use App\Http\Controllers\Admin\CourseController;
    use App\Http\Controllers\Admin\CourseOfferingController;
    use App\Http\Controllers\Admin\DepartmentController;
    use App\Http\Controllers\Admin\StudentController;
    use App\Http\Controllers\Admin\TeacherController;
    use App\Http\Controllers\ProfileController;
    use App\Http\Controllers\Student\StudentDashboardController;
    use App\Http\Controllers\Teacher\AttendanceController;
    use App\Http\Controllers\NotificationController;
    use Illuminate\Support\Facades\Route;
// ********************* Web Routes *****************************

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('dashboard');
        Route::resource('departments', DepartmentController::class);
        Route::resource('courses', CourseController::class);
        Route::resource('teachers', TeacherController::class);
        Route::resource('students', StudentController::class);
        Route::resource('course-offerings', CourseOfferingController::class);
    });
//  ********************* Profile Routes *****************************
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//  ********************* Teacher Routes *****************************
Route::middleware(['auth', 'verified', 'role:teacher'])
    ->prefix('teacher')
    ->name('teacher.')
    ->group(function () {

        Route::get('/', function () {
            return redirect()->route('teacher.courses.index');
        })->name('dashboard');
        Route::get('/courses', [TeacherCourseController::class, 'index'])
            ->name('courses.index');
        Route::get('/courses/{offering}', [TeacherCourseController::class, 'show'])
            ->name('courses.show');
        Route::get('/courses/{offering}/students', [TeacherEnrollmentController::class, 'index'])
            ->name('courses.students');

        // Material Routes For Teacher
        Route::prefix('courses/{offering}')
            ->name('materials.')
            ->group(function () {
                Route::get('/materials', [MaterialController::class, 'index'])->name('index');   // = teacher.materials.index
                Route::get('/materials/create', [MaterialController::class, 'create'])->name('create');  // = teacher.materials.create
                Route::post('/materials', [MaterialController::class, 'store'])->name('store');   // = teacher.materials.store
                Route::delete('/materials/{material}', [MaterialController::class, 'destroy'])->name('destroy'); // = teacher.materials.destroy
            });
        // Assignment Routes For Teacher
        Route::prefix('courses/{offering}')
            ->name('assignments.')
            ->group(function () {
                Route::get('/assignments', [AssignmentController::class, 'index'])->name('index');   // = teacher.assignments.index
                Route::get('/assignments/create', [AssignmentController::class, 'create'])->name('create');  // = teacher.assignments.create
                Route::post('/assignments', [AssignmentController::class, 'store'])->name('store');   // = teacher.assignments.store
                Route::delete('/assignments/{assignment}', [AssignmentController::class, 'destroy'])->name('destroy'); // = teacher.assignments.destroy
            });
        // Exam Routes For Teacher
        Route::prefix('courses/{offering}/exams')
            ->name('exams.')
            ->group(function () {
                Route::get('/', [ExamController::class, 'index'])->name('index');
                Route::get('/create', [ExamController::class, 'create'])->name('create');
                Route::post('/', [ExamController::class, 'store'])->name('store');
            });

        // Exam Results Routes For Teacher
        Route::prefix('courses/{offering}/exams/{exam}/results')
            ->name('exams.results.')
            ->group(function () {
                Route::get('/', [ExamResultController::class, 'index'])->name('index');
                Route::put('/{student}', [ExamResultController::class, 'update'])->name('update');
            });

        // Submission Routes For Teacher
        Route::prefix('courses/{offering}/assignments/{assignment}')
            ->name('submissions.')
            ->group(function () {
                Route::get('/submissions', [SubmissionController::class, 'index'])
                    ->name('index');   // teacher.submissions.index

                Route::put('/submissions/{submission}', [SubmissionController::class, 'update'])
                    ->name('update');  // teacher.submissions.update
            });

        // Attendance Routes For Teacher
        Route::prefix('courses/{offering}/attendance')
            ->name('attendance.')
            ->group(function () {
                Route::get('/', [AttendanceController::class, 'index'])->name('index');
                Route::get('/create', [AttendanceController::class, 'create'])->name('create');
                Route::post('/', [AttendanceController::class, 'store'])->name('store');

                Route::get('/{session}/mark', [AttendanceController::class, 'mark'])->name('mark');
                Route::post('/{session}/mark', [AttendanceController::class, 'update'])->name('update');
            });
    });

//  ********************* Student Routes *****************************
Route::middleware(['auth', 'verified', 'role:student'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {

        Route::get('/grades', [StudentGradeController::class, 'index'])
            ->name('grades.index');

        Route::get('/courses/{offering}/grades', [StudentGradeController::class, 'show'])
            ->name('courses.grades.show');

        Route::get('/courses', [StudentEnrollmentController::class, 'index'])
            ->name('courses.index');
        Route::post('/courses/{offering}/enroll', [StudentEnrollmentController::class, 'enroll'])
            ->name('courses.enroll');
        Route::delete('/courses/{offering}/unenroll', [StudentEnrollmentController::class, 'unenroll'])
            ->name('courses.unenroll');
        // Dashboard Routes For Student
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])
            ->name('dashboard');
        // Assignment Routes For Student
        Route::get('/assignments/{assignment}', [AssignmentSubmissionController::class, 'show'])
            ->name('assignments.show');
        Route::post('/assignments/{assignment}/submit', [AssignmentSubmissionController::class, 'store'])
            ->name('assignments.submit');
        // Exam Routes For Student
        Route::get('/courses/{offering}/exams', [StudentExamController::class, 'index'])
            ->name('courses.exams.index');
        // attendance Routes For Student
        Route::get('/courses/{offering}/attendance', [StudentAttendanceController::class, 'index'])
            ->name('courses.attendance.index');
    });


// ********************* Notifications Routes *****************************
Route::middleware(['auth'])
    ->group(function () {
        Route::get('/notifications', [NotificationController::class, 'index'])
            ->name('notifications.index');

        Route::get('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])
            ->name('notifications.read');
    });



require __DIR__ . '/auth.php';



