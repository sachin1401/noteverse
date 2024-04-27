<?php 
// INSERT INTO `todo` (`sno`, `title`, `description`, `dt`) VALUES (NULL, 'buy fruits', 'watermelon, apple, banana', current_timestamp());
$insert = false;
$update = false;
$delete = false;
$server = "localhost";
 $username = "root";
 $password = "";
 $database = "todos";

// create connection
 $con = mysqli_connect($server, $username, $password, $database);

 if(!$con) {
     die("connection un-sucessfully" . mysqli_connect_error());
 }else{
    //  echo "connection sucessfully <br>";
 }
 if(isset($_GET['delete'])){
    $sno = $_GET['delete'];
    $delete = true;
    $sql = "DELETE FROM `todo` WHERE `sno` = $sno";
    $result = mysqli_query($con, $sql);
  } 
//  echo $_SERVER['REQUEST_METHOD'];
 if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['snoEdit'])){
        // update the note
        $sno = $_POST["snoEdit"];
        $title = $_POST["titleEdit"];
        $details = $_POST["detailsEdit"];
        $sql ="UPDATE `todo` SET `title` = '$title' , `details` = '$details' WHERE `todo`.`sno` = $sno";
        $result = mysqli_query($con, $sql);
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    }
    else{
        $title = $_POST["title"];
        $details = $_POST["details"];
    
        // echo $titles;
    
        $sql ="INSERT INTO `todo` (`title`, `details`, `dt`) VALUES ('$title', '$details', current_timestamp());";
        $result = mysqli_query($con, $sql);
    
        if($result) {
        //   echo "sucessful insert";
        $insert = true;
        // Redirect to prevent form resubmission
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();

        }else  {
        echo "error" . mysqli_error($con);
        }
     }
   }
  
 
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NoteVerse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.5/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
 
   
  </head> 
  <body>
    <!-- Edit modal -->
    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
    Edit modal
    </button> -->

    <!--Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="editModalLabel">Edit This Note:</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="/todo/index.php" method="post">
                <input type="hidden" name="snoEdit" id="snoEdit">
                <h2>Add a Note</h2>
                <div class="mb-3">
                <label for="title" class="form-label">Note Title</label>
                <input type="text" class="form-control" placeholder="Enter a note here" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
                </div>
            
                <div class="form-group">
                    <label for="other">Note Description</label>
                    <textarea class="form-control" placeholder="Enter a descripiton here" id="detailsEdit" name="detailsEdit" style="height: 100px"></textarea>                
                </div>
            
                <button type="submit" class="btn btn-primary my-2">Update Note</button>
            </form>
        </div>
        <!-- <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
        </div> -->
        </div>
    </div>
    </div>

    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar bg-primary bg-body-tertiary" data-bs-theme="dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">NoteVerse</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Contact Us</a>
              </li>
             
              <li class="nav-item">
                <!-- <a class="nav-link disabled" aria-disabled="true">Disabled</a> -->
              </li>
            </ul>
            <form class="d-flex" role="search">
              <!--  tton class="btn btn-outline-success" type="submit">Search</button> -->
            </form>
          </div>
        </div>
      </nav>
    <!-- sucess message -->
    <?php 
    if($insert) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Sucess!</strong> Your note has been inserted sucessfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }  
    ?>
     <?php
  if($delete){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your note has been deleted successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
  }
  ?>
  <?php
  if($update){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your note has been updated successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
  }
  ?>
      <div class="container  my-4">
        <form action="/todo/index.php" method="post">
            <h2>Add a Note</h2>
            <div class="mb-3">
              <label for="title" class="form-label">Note Title</label>
              <input type="text" class="form-control" placeholder="Enter a note here" id="title" name="title" aria-describedby="emailHelp">
            </div>
        
            <div class="form-group">
                <label for="other">Note Description</label>
                <textarea class="form-control" placeholder="Enter a descripiton here" id="details" name="details" style="height: 100px"></textarea>                
              </div>
        
            <button type="submit" class="btn btn-primary my-2">Add Note</button>
          </form>
      </div>

      <div class="container my-4">

            <table class="table" id="myTable">
              <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">TITLE</th>
                  <th scope="col">DESCRIPTION</th>
                  <th scope="col">ACTIONS</th>
                </tr>
              </thead>
              <tbody>
              <?php
                $sql="SELECT * FROM `todo`";
                $result =mysqli_query($con, $sql);
                $sno = 0;
                while($row = mysqli_fetch_assoc($result)){
                    $sno += 1;
                  echo "<tr>
                  <th scope='row'>". $sno . "</th>
                  <td>". $row['title'] . "</td>
                  <td>". $row['details'] . "</td>
                  <td><button class='edit btn btn-sm btn-primary' id=".$row['sno'].">Edit</button> <button class='delete btn btn-sm btn-primary' id=d".$row['sno'].">Delete</button> </td>
                </tr>";
           
            }
        ?>
              
              </tbody>
            </table>
      </div>
      <hr>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/2.0.5/js/dataTables.min.js"></script>
     <script>
        let table = new DataTable('#myTable');
     </script>
      <script>
        // edit the note
        edits = document.getElementsByClassName('edit');
        Array.from(edits).forEach((element) =>{
            element.addEventListener("click", (e)=>{
                console.log("edit", );
                tr = e.target.parentNode.parentNode;
                title = tr.getElementsByTagName("td")[0].innerText;
                details = tr.getElementsByTagName("td")[1].innerText;
                console.log(title, details);
                detailsEdit.value = details;
                titleEdit.value = title;
                snoEdit.value = e.target.id;
                $('#editModal').modal('toggle');
            })
        })
// delete the note
        deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element) =>{
            element.addEventListener("click", (e)=>{
                console.log("edit", );
                sno =e.target.id.substr(1,);
              
                if(confirm("Are you sure you want to delete this note?")) {
                    console.log("yes")
                    window.location = `/todo/index.php?delete=${sno}` ;
                }else{
                    console.log("no")
                }
            })
        })
    </script>
  </body>
</html>