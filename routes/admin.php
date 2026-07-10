<?php
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\DayController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TeachingController;
use App\Http\Controllers\TimeController;
use App\Http\Controllers\YearController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {

    // homepage route
    Route::get('home', [AdminController::class, 'adminHome'])->name('adminHome');

    //days
    Route::group(['prefix' => 'day'], function () {
        Route::get('list', [DayController::class, 'list'])->name('day.list');
        Route::post('create', [DayController::class, 'create'])->name('day.create');
        Route::get('update/{id}', [DayController::class, 'updatePage'])->name('day.updatePage');
        Route::post('update/{id}', [DayController::class, 'update'])->name('day.update');
        Route::get('delete/{id}', [DayController::class, 'delete'])->name('day.delete');
    });

    //years
    Route::group(['prefix' => 'year'], function () {
        Route::get('list', [YearController::class, 'list'])->name('year#list');
        Route::post('create', [YearController::class, 'create'])->name('year#create');
        Route::get('update/{id}', [YearController::class, 'updatePage'])->name('year#updatePage');
        Route::post('update/{id}', [YearController::class, 'update'])->name('year#update');
        Route::get('delete/{id}', [YearController::class, 'delete'])->name('year#delete');
    });

    //profile
    Route::group(['prefix' => 'profile'], function () {
        Route::get('changePassword', [ProfileController::class, 'changePasswordPage'])
            ->name('profile.changePassword.page');
        Route::post('changePassword', [ProfileController::class, 'changePassword'])->name('profile#changePassword');

        Route::get('profile', [ProfileController::class, 'accountProfile'])->name('profile.accountProfile');
        Route::get('edit', [ProfileController::class, 'editProfile'])->name('profile.editProfile');
        Route::post('update', [ProfileController::class, 'updateProfile'])->name('profile.updateProfile');

        Route::group(['middleware' => 'superadmin'], function () {
            Route::get('add/newAdmin', [ProfileController::class, 'createNewAdminAccount'])->name('profile#createNewAdminAccount');
            Route::post('add/newAdmin', [ProfileController::class, 'createAdminAccount'])->name('profile#createAdminAccount');
            Route::get('admin/list', [ProfileController::class, 'adminList'])->name('profile.adminList');
            Route::get('admin/delete/{id}', [ProfileController::class, 'delete'])->name('profile.adminDelete');

            //user list
            Route::get('user/list', [ProfileController::class, 'userList'])->name('profile.userList');
            Route::get('user/delete/{id}', [ProfileController::class, 'userDelete'])->name('profile.userDelete');
        });
    });

    //majors
    Route::group(['prefix' => 'major'], function () {
        Route::get('create', [MajorController::class, 'create'])->name('major.create');
        Route::post('create', [MajorController::class, 'createMajor'])->name('major.createMajor');
        Route::get('list', [MajorController::class, 'list'])->name('major.list');
        Route::get('update/{id}', [MajorController::class, 'updatePage'])->name('major.updatePage');
        Route::post('update/{id}', [MajorController::class, 'update'])->name('major.update');
        Route::get('delete/{id}', [MajorController::class, 'delete'])->name('major.delete');
    });

    //classes or rooms
    Route::group(['prefix' => 'room'], function () {
        Route::get('create', [RoomController::class, 'create'])->name('room.create');
        Route::post('create', [RoomController::class, 'createRoom'])->name('room.createRoom');
        Route::get('list', [RoomController::class, 'list'])->name('room.list');
        Route::get('update/{id}', [RoomController::class, 'updatePage'])->name('room.updatePage');
        Route::post('update/{id}', [RoomController::class, 'update'])->name('room.update');
        Route::get('delete/{id}', [RoomController::class, 'delete'])->name('room.delete');
    });

    //departments
    Route::group(['prefix' => 'department'], function () {
        Route::get('list', [DepartmentController::class, 'list'])->name('department.list');
        Route::post('create', [DepartmentController::class, 'create'])->name('department.create');
        Route::get('update/{id}', [DepartmentController::class, 'updatePage'])->name('department.updatePage');
        Route::post('update/{id}', [DepartmentController::class, 'update'])->name('department.update');
        Route::get('delete/{id}', [DepartmentController::class, 'delete'])->name('department.delete');
    });

    //positions
    Route::group(['prefix' => 'position'], function () {
        Route::get('list', [PositionController::class, 'list'])->name('position.list');
        Route::post('create', [PositionController::class, 'create'])->name('position.create');
        Route::get('update/{id}', [PositionController::class, 'updatePage'])->name('position.updatePage');
        Route::post('update/{id}', [PositionController::class, 'update'])->name('position.update');
        Route::get('delete/{id}', [PositionController::class, 'delete'])->name('position.delete');
    });

    //teachers
    Route::group(['prefix' => 'teacher'], function () {
        Route::get('create', [TeacherController::class, 'create'])->name('teacher.create');
        Route::post('create', [TeacherController::class, 'createTeacher'])->name('teacher.createTeacher');
        Route::get('list', [TeacherController::class, 'list'])->name('teacher.list');
        Route::get('update/{id}', [TeacherController::class, 'updatePage'])->name('teacher.updatePage');
        Route::post('update/{id}', [TeacherController::class, 'update'])->name('teacher.update');
        Route::get('delete/{id}', [TeacherController::class, 'delete'])->name('teacher.delete');
    });

    //subjects
    Route::group(['prefix' => 'subject'], function () {
        Route::get('create', [SubjectController::class, 'create'])->name('subject.create');
        Route::post('create', [SubjectController::class, 'createSubject'])->name('subject.createSubject');
        Route::get('list', [SubjectController::class, 'list'])->name('subject.list');
        Route::get('update/{id}', [SubjectController::class, 'updatePage'])->name('subject.updatePage');
        Route::post('update/{id}', [SubjectController::class, 'update'])->name('subject.update');
        Route::get('delete/{id}', [SubjectController::class, 'delete'])->name('subject.delete');
    });

    //time
    Route::group(['prefix' => 'time'], function () {
        Route::get('list', [TimeController::class, 'list'])->name('time.list');
        Route::post('create', [TimeController::class, 'create'])->name('time.create');
        Route::get('update/{id}', [TimeController::class, 'updatePage'])->name('time.updatePage');
        Route::post('update/{id}', [TimeController::class, 'update'])->name('time.update');
        Route::get('delete/{id}', [TimeController::class, 'delete'])->name('time.delete');
    });

    //teaching classes
    Route::group(['prefix' => 'teaching'], function () {
        Route::get('create', [TeachingController::class, 'create'])->name('teaching.create');
        Route::post('create', [TeachingController::class, 'createTeaching'])->name('teaching.createTeaching');
        Route::get('list', [TeachingController::class, 'list'])->name('teaching.list');
        Route::get('update/{id}', [TeachingController::class, 'updatePage'])->name('teaching.updatePage');
        Route::post('update/{id}', [TeachingController::class, 'update'])->name('teaching.update');
        Route::get('delete/{id}', [TeachingController::class, 'delete'])->name('teaching.delete');
    });

    //schedules
    Route::group(['prefix' => 'schedule'], function () {
        Route::get('create', [ScheduleController::class, 'create'])->name('schedule.create');
        Route::post('create', [ScheduleController::class, 'createSchedule'])->name('schedule.createSchedule');
        Route::get('list', [ScheduleController::class, 'list'])->name('schedule.list');
        Route::get('update/{id}', [ScheduleController::class, 'updatePage'])->name('schedule.updatePage');
        Route::post('update/{id}', [ScheduleController::class, 'update'])->name('schedule.update');
        Route::get('delete/{id}', [ScheduleController::class, 'delete'])->name('schedule.delete');

        //time table
        Route::get('timetable', [ScheduleController::class, 'timetable'])->name('schedule.timeTable');
        Route::get('viewSchedule/{id}', [ScheduleController::class, 'viewSchedule'])->name('schedule.viewSchedule');
        Route::post('/schedule/result/{year}', [ScheduleController::class, 'result'])->name('schedule.result');
        //print & PDF
        Route::get('/schedule/pdf/{year}/{room}/{major}', [ScheduleController::class, 'downloadPDF'])->name('schedule.pdf');
        //teacher time table
        Route::get('/schedule/teacher-time-table/{yearID}',[ScheduleController::class,'teacherTimeTable'])->name('schedule.teacherTimeTable');
    });

});
