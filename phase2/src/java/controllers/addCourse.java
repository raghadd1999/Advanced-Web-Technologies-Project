package controllers;

import beans.Course;
import java.io.IOException;
import java.sql.SQLException;
import javax.servlet.RequestDispatcher;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

public class addCourse extends HttpServlet {

    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        try {

            Course course = null;
            try {
                int course_id = Integer.parseInt(request.getParameter("course_id"));
                int inst_id = Integer.parseInt(request.getParameter("inst_id"));
                String course_name = request.getParameter("course_name");
                String course_field = request.getParameter("course_field");
                String course_description = request.getParameter("course_description");

                course = new Course(course_id, inst_id, course_name, course_field, course_description);

                if (course.getInstructor().getId() == 0) {
                    throw new ServletException("Instructor not found.");
                }

            } catch (NumberFormatException e) {
                throw new ServletException("Instructor ID must be number.");
            }

            if (course != null && course.insertIntoDatabase()) {
                request.getSession().setAttribute("Course", course);
                request.getSession().setAttribute("Instructor", course.getInstructor());

                RequestDispatcher rd = request.getRequestDispatcher("/showCourse.jsp");
                rd.forward(request, response);
            } else {
                throw new ServletException("Error in inserting the course");
            }
        } catch (Exception ex) {
            throw new ServletException(ex);
        }
    }
}
