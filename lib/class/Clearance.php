<?php 

class Clearance extends tblsql{
    /*update cleraance*/
    public function update($empid, $dbname, $email, $contact, $add)
    {
        $update = "UPDATE HREmpClearance SET
                        PersonalEmail='$email',
                        ContactNumber='$contact',
                        PermanentAddress='$add',
                        EmployeeUpdatedAt=GETDATE()
                    WHERE EmpID='$empid' AND DBNAME='$dbname'";
        $result = $this->get_execute($update);

        return $result;
    }

}