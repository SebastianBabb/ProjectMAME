<?php 

$roms_directory = '/home/sebastian/roms';


if(isset($_POST['rom_id'])) {
    delete_rom();
}

if(isset($_POST['submit_rom'])) {
    add_rom();
}

$roms = array_diff(scandir($roms_directory), array('..', '.'));


?>


<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1">

        <title>MAME::System Manager</title>
        <link rel="icon" href="img/favicon.png">

        <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="css/style.css" rel="stylesheet" media="screen">

        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/scripts.js"></script>
    </head>
    <body>
        <!-- grid graphic top -->
        <div id='grid-top'></div>
        <!-- ./grid graphic top -->

        <!-- header -->
        <div id='header-container'>
            <div class='container header-text-container'>
                <h1>Sebastian's Arcade</h1>
                <h2>System Manager</h2>
            </div>
            <hr class='header-line'>
        </div>
        <!-- ./header -->

        <!-- main content -->
        <div class='containera hud'>
            <div class='container'>
                <div class='row'>
                    <div class='panel'>
                        <div class='panel-header'>
                            System Information 
                        </div>
                        <div class='panel-body'>
                            <div class='col-md-5'>
                                <div class='panel'>
                                    <div class='panel-header'>
                                        Disk Usage 
                                    </div>
                                    <div class='panel-body'>
                                        <ul>
                                            <li><span class='title'>Hostname: </span><span class='value'> Arcade<span></li> 
                                            <li><span class=''>Operating System: </span><span class=''> GNU/Linux<span></li> 
                                            <li><span class=''>Kernel: </span><span class=''> 3.85ARCH<span></li> 
                                            <li><span class=''>IP: </span><span class=''>192.168.54.254<span></li> 
                                        </ul>
                                    </div>
                                </div>
                                <div class='panel'>
                                    <div class='panel-header'>
                                        Active Users
                                    </div>
                                    <div class='panel-body'>
                                        <ol style='padding-left:15px;'>
                                            <li>pacman</li> 
                                        </ol>
                                        * There should really only be one active user.
                                    </div>
                                </div>
                            </div>
                            <div class='col-md-7'>
                                <div class='panel'>
                                    <div class='panel-header'>
                                        Disk Usage 
                                    </div>
                                    <div class='panel-body'>
                                        <ul>
                                            <li><span>Hard Disk Usage:  </span><span>35GB/90GB</span></li> 
                                            <div class="progress">
                                              <div class="progress-bar" role="progressbar" aria-valuenow="70"
                                                aria-valuemin="0" aria-valuemax="100" style="width:70%">
                                                70%
                                              </div>
                                            </div>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='row'>
                    <div class='panel'>
                        <div class='panel-header'>
                            Manage ROMs 
                        </div>
                        <div class='panel-body'>
                            <div class='col-md-offset-0 col-md-12'>
                                <div class='panel'>
                                    <div class='panel-header'>
                                        Upload ROM File 
                                    </div>
                                    <div class='panel-body'>
                                        <form action="index.php" method="post" enctype="multipart/form-data">
                                            <div class='input-group'>
                                                <label class="input-group-btn">
                                                    <span class="btn btn-tron">
                                                        Browse&hellip; <input onchange="load_file()" name="rom_file" id="rom_file" type="file" style="display: none;" multiple>
                                                    </span>
                                                </label>
                                                <input class="form-control input-tron" type="text" value="Rom file..." id="submit_rom" name="submit_rom">
                                            </div>
                                            <input style='margin-top: 10px;'class="btn btn-tron" type="submit" value="Upload" name="submit_rom">
                                        </form>
                                    </div>
                                </div>
                                <?php 
                                    // Display message.
                                    if(isset($message)) {
                                        echo "
                                            <div class='panel'>
                                                <div class='panel-header' style='text-align: center; border-bottom: none'>
                                                   {$message}
                                                </div>
                                            </div>
                                        ";
                                    }
                                ?>
<!--                            </div>
                            <div class='col-md-6'> -->
                                <div class='panel'>
                                    <div class='panel-header'>
                                        Active ROMs 
                                    </div>
                                    <!-- remove padding inline for roms list panel -->
                                    <div class='panel-body' style='padding:0px;'>
                                        <ul class='rom-list'>
                                            <?php
                                                echo "<li style='text-align:center'>Total Number of ROMs:  " . count($roms) . "</li>";
                                                foreach($roms as $index => $rom) {
                                                    echo "
                                                        <form action='index.php' method='post' onclick=\"return confirm_delete('{$rom}');\">
                                                            <input name='rom_id' type='hidden' value='{$index}'>
                                                            <li>
                                                                <div class='row'>
                                                                    <div class='pull-left'>
                                                                        <span>{$rom}</span>
                                                                    </div>
                                                                    <div class='pull-right'>
                                                                        <button type='submit'>Delete</button>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </form>";
                                                }
                                            ?>  
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- main content -->

        <!-- grid graphic bottom -->
        <div id='grid-bottom' class="footer"></div>
        <!-- ./grid graphic bottom -->
    </body>
</html>


<?php
/**
 * Short description for index.php
 *
 * @package index
 * @author sebastian <sebastian@masterControl>
 * @version 0.1
 * @copyright (C) 2017 sebastian <sebastian@masterControl>
 * @license MIT
 */

/*
 * Remove 
 */
function delete_rom() {
    // Make global variables accessible to the function.
    global $roms_directory;
    global $message;

    // Get a list of the roms in directory.
    $roms = scandir($roms_directory);

    $rom_id = $_POST['rom_id'];

    $file_name = $roms[$rom_id];
    $target_file = $roms_directory .'/'. $file_name;

    if(unlink($target_file)) {
        $message = "<span style='color: red;'>{$file_name} deleted..</span>";
    } else {
        $message = "<span style='color: red;'>Could not delete {$file_name}.</span>";
    }
}

/*
 * Ensure file_upload = On in php.ini
 */
function add_rom() {
    // Make global variables accessible to the function.
    global $roms_directory;
    global $message;

    // Get a list of the roms in directory.
    $roms = array_diff(scandir($roms_directory), array('..', '.'));


    /*
     * Get the name of the rom file being uploaded and create its target
     * path (where it will be saved in the filesystem).
     */
    $file_name = basename($_FILES["rom_file"]["name"]);
    $target_file = $roms_directory .'/'. $file_name;

    /*
     * Isolate the file extension and check that its one of the two allowed
     * formats (zip or rar).
     */
    $file_type = pathinfo($target_file, PATHINFO_EXTENSION);

    if(strcmp($file_type, "zip") == 0 || strcmp($file_type, "rar") == 0) {
        // Valid file format, check if rom already exists.
        if(file_exists($target_file)) {
            // Rom exists, display error.
            $message = "<span style='color: red;'>{$file_name} already exists.</span>";
        } else {
            // Upload rom file.
            if(move_uploaded_file($_FILES["rom_file"]["tmp_name"], $target_file)) {
                /*
                 * Successful upload.  Set message variable so the the
                 * script knows to load the successful upload dialog.
                 */
                $message = "<span style='color: green;'>{$file_name} succesfully added.</span>";
            } else {
                // Upload error.  Display error message.
                $message = "There was an error adding {$file_name}.";
            }
        }
    } else {
        // Invalid file format.  Display error.
        $message = "<span style='color: red;'>Invalid filetype for {$file_name}.  Only .zip and .rar files can be added.</span>";
    }
} // end add_rom

?>
