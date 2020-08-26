package beans;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;

public class Instructor {

    private int id;
    private String username;
    private String password;
    private String name;
    private String email;
    private String speciality;

    public Instructor() {

    }

    public Instructor(int id) throws Exception {
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
            
            Statement statement = con.createStatement();
            ResultSet resultSet = statement.executeQuery("select * from instructor where id='" + id + "'");
            if (resultSet.next()) {
                this.id = resultSet.getInt("id");
                this.username = resultSet.getString("username");
                this.password = resultSet.getString("password");
                this.name = resultSet.getString("name");
                this.email = resultSet.getString("email");
                this.speciality = resultSet.getString("speciality");
            }
        }//end try
        catch (SQLException ex) {
            System.out.println("Error: Could not connect to mySQL server");
            System.out.println(ex.getMessage());
            throw ex;
        }
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getUsername() {
        return username;
    }

    public void setUsername(String username) {
        this.username = username;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public String getSpeciality() {
        return speciality;
    }

    public void setSpeciality(String speciality) {
        this.speciality = speciality;
    }

}
