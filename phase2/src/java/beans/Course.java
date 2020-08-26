package beans;

import java.sql.*;

public class Course {

    private int id;
    private String name;
    private String field;
    private String description;
    private Instructor instructor;

    public Course(int course_id, int inst_id, String course_name, String course_field, String course_description) throws Exception {
        id = course_id;
        name = course_name;
        field = course_field;
        description = course_description;
        instructor = new Instructor(inst_id);
    }

    public boolean insertIntoDatabase() throws Exception {
        Connection con = null;
        try {
            Class.forName("com.mysql.jdbc.Driver");
        }//end try
        catch (ClassNotFoundException ex) {
            System.out.println("Error: MySQL driver not fount..");
            System.out.println(ex.getMessage());
            throw ex;
        }//end catch
        try {
            //To get th port: check the setting of XAMPP or MAMP
            con = DriverManager.getConnection("jdbc:mysql://localhost:3306/ksu_courses", "root", "");

            String query = "insert into course (id, instructor_id, name, field, description) values ('" + id + "', '" + instructor.getId() + "', '" + name + "', '" + field + "', '" + description + "');";
            PreparedStatement statment = con.prepareStatement(query);

            int r = statment.executeUpdate();
            statment.close();

            if (r > 0) {
                return true;
            }
        }//end try
        catch (SQLException ex) {
            System.out.println("Error: Could not connect to mySQL server");
            System.out.println(ex.getMessage());
            throw ex;
        }

        return false;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getField() {
        return field;
    }

    public void setField(String field) {
        this.field = field;
    }

    public String getDescription() {
        return description;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public Instructor getInstructor() {
        return instructor;
    }

    public void setInstructor(Instructor instructor) {
        this.instructor = instructor;
    }

}
