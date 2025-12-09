<?php
session_start();

// Clear all session variables
session_unset();

// Destroy the session
session_destroy();

// Also clear the session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Redirect back to login page
header('Location: index.php?page=login');
exit;

/* 
1.) How did you implement different navigation menus or page access based on user roles (e.g., staff vs admin)? What security considerations are important?
        I implemented different navigation menus and page access based on user roles by checking the user's status stored in the session variable. 
        In the navigation.php file, I  added links to the navigation menu based on whether the user is logged in and their role (admin or staff).
        In the security.php file, I enforced role-based access control by redirecting users who attempt to access admin-only pages if they do not have the 'admin' status.
        Important security considerations include ensuring that sensitive pages are protected from unauthorized access, validating user roles on each request, and preventing session hijacking by properly managing session data.



2.)How does a router file determine which view or controller to load based on URL parameters? What are the benefits of this approach compared to having separate PHP files for each page?
        The router file checks the page parameter in the URL and uses if-else statements to determine which view file to load. 
        Runs the security checks, loads the matching view file. If someone enters an invalid page name or parameter, it redirects to the login page.
        Benefits of this is one entry point for all requests, so I only need to include security checks once instead of every file.

3.)Explain how sessions are used in this application for authentication. What happens when a user logs in, and how does the application maintain their authenticated state across page requests?
        Sessions are used to store user information after a successful login. At the beginning of the index.php file, session_start()
        The login controller checks email and password against the database. 
        On every page request the security file checks if the user session exists to determine if the user is logged in.


4.)How does organizing your application into folders like views, controllers, routes, and includes improve code organization? What problems does this structure solve compared to having all files in a single directory?
        Improves code organization by separating concerns.
        Views handle presentation, controllers handle business logic, routes manage navigation, and includes contain reusable components.
        This structure solves problems like code duplication, difficulty in maintenance.
        If all files were in a single directory, it would be harder to find specific files, leading to confusion and errors.

5.)Trace the flow of a typical user request in this application, from when a user clicks a link or submits a form to when they see the response. Include the role of the router, security checks, controllers, and views.
        When a user clicks a link or submits a form, the request goes to index.php with a page parameter.
        The router.php file checks the page parameter and includes security.php to enforce access control.
        If the user is authorized, the router includes the appropriate view file based on the page parameter.
        If the request involves form submission, the corresponding controller processes the input, interacts with the database, and prepares data for the view.
        Finally, the view renders the HTML response, which is sent back to the user's browser for display.
        */