<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About The Bounty Board System 
The system was created with laravel and bootstrap. It's purpose was to create an environment for the admin and th users to complete internal tasks of a company.

The system used bootstrap auth scaffolding for authentication because of its ease of deployment and because it directly allows us to authenticate users to achieve our system's requirements. However the register was modified to take phone number and department input from the user as specified in the task requirements. It was possible for me to create a login system with JWT for example but the focus of the requirements were not about creating an authentication system from scratch.


## System Implementation and Design 

## Database
First, the database migrations were created and other than the three default migrations for users, passwords and failed jobs, I created 6 migrations as follow:
departments migration, comments migration, tasks migration, requirements migration, task_user migration, and deliverables migration.

The department table only stores a department name and id but the id of it is used as a foreign key in the tasks and users tables.

The comments migration has a commentable_type and commentable_id columns because comments usually associates with other elements as a polymorphic relationship.
However, the commentable type will always be task because we don't have other elements that we want to comment on in our system. The commentable_id will be the id of the task 
related to this comment. There is a somewhat similar relationship between tasks and requirements where each task can have multiple requirements associated with it. 

The task_user migration is created in oreder to create a pivot table that allows for a many to many relationship between tasks and users. Each record in this table represents 
a claim request from a specific user to a specific task and everything will be recorded there.

The deliverable migration stores the data of delivery requests such as the title, description and the path to the deliverable file (in the server's storage) that the user attached  when he finishes the task and makes the request. 


## Backend
When it comes to backend I created 4 controllers other than the Auth controllers for the authentication system that I mentioned earlier. There are two seperate Task controllers. One is for the user and one is for the admin. 

The AdminTaskController has the following:
-index method the returns the index view with created tasks. 
-create method that only returns the view for creating a task. 
-store method that validates the input and insert the record in the database using 'DB' query builder into tasks table and the requirements into its own table.
-edit method that returns the view for reviewing a tsak.
-Update method that stores the new data that the admin inserts also after validation and it deletes the old associated requirements from the db and inserts the new
  ones that the admin decides. So, that we don't associate some requiremntes twice or make unwanted relationships.
-displayClaimRequests method that returns all claim requests in a view and when the admin accepts a user for a specific task, the system automatically hides the other              requests for that task since it is already associated with a specific user.
-respondeToClaimRequest method allows the admin to approve or disapprove a user to claim a task and that approval or reject will be stored in task_user table

The UserTaskController has the following: 
-index method that returns the view of all the tasks that are posted for his/her department.
-taskHistory method that returns the view of all claimed tasks that still needs work as well as completed and ones that needs to be delivered
-updateProgress method that recieves an ajax request for the progress of a specific task that and updates it based on the user input (0.00-1.00). And when the user inputs 1,    it enables him/her to make delivery request for that task.
-makeClaimRequest method which has a security measure that checks if the user is requesting a task from his department and if so, it proceeds and create the request.
    it also checks if the user has already claimed this task and it returns a response accordingly for the user.
    
The DeliverableController has the following:
 Two methods for the user which are:
 -create method that checks if the user has finished the task and then it returns the view for creating a delivery request.
 -store method which validates user input and store the delivery request in the DB and stores the file in the storage.
 Three methods for the admin which are:
 -index method that return all deliverable requets to the admin
 -respondeToDeliveryRequest method that by which the admin can approve a request or disapprove it and delete its associated file from the DB.
 -download method that allows the admin to download the submitted file to review it before making an approvment.
 
 The CommentController has the following:
 -makeComment method which recieves an ajax request validates it is not empty and then store the comment in the DB and associate it with the task and the user that are related      to it.
 -returnComments method which takes a task_id and return all associated comments and task details in a view 
 
 All associated routes for these methods were created in web.php with the relevant Http method (POST for creation, PUT for updating, ..ect).
 
 A middleware called Admin.php was created and registered in the kernel to be able to use it on routes as 'isAdmin'.
 
 I created two route groups one with 'auth' middleware for the users and one with 'auth' and 'isAdmin' for the admin to add security layer on the backend and not allow users or non logged-ins to perform what they are not authorized to. 
 
 #NOTES:
 *I used query builders and that's why I didn't use models.
 *I used 'Session::flash()' method to notify users and 'redirect()' helper function to redirect them to the desired frontend views.

## Frontend
I used Laravel's Blade templating engine to create frontend views. The most important views are already mentioned in the controllers discussion.

The general structure of the frontend views is as follows.

In the resources/views directory there is the following:
-admin directory that contains the discussed admin view for showing tasks and requests, creating tasks, and editing them.
-auth directory that contains the views for login, register and others.
-layouts directory that contains a view called app.blade.php that I used as a parent view and created other view from extending it and putting the content in a section called 'content'.
-user directory which has views for creating delivery requests, showing tasks for user's department (index), and showing own tasks.
- There is a view called task.blade.php which is responsible for showing task details, like its requirements, showing the comment section for that task, and display a claim button if the user is not an admin. This view is not in a directory since both the admin and the user use it.

#NOTE:
Ajax is used in some views, like the task view to append comments for example, to avoid reload. It is also used to update task progress for users.


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
