<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Windows Phone Online</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
        }

        h1 {
            color: #333;
        }

        p {
            margin-bottom: 10px;
        }

        form {
            margin-bottom: 20px;
        }

        input[type="text"] {
            padding: 5px;
            width: 200px;
            font-size: 14px;
        }

        input[type="submit"] {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .download {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .download a {
            color: #333;
            text-decoration: none;
            font-weight: bold;
        }

        .download a:hover {
            text-decoration: underline;
        }

        .download p {
            margin-top: 5px;
            color: #666;
            font-size: 12px;
        }

        /* Scrollable frame for the disclaimer */
        .disclaimer-frame {
            height: 400px; /* Adjust the height as needed */
            overflow: auto;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php
    // Disclaimer
    echo '
    <h1>Disclaimer</h1>
    <div class="disclaimer-frame">
        <p>Thank you for visiting our website, dedicated to preserving the legacy of Windows Phone devices and ensuring their continued usability. It is important to understand that while we are passionate about this endeavor, we must emphasize that we do not possess any licenses for the material hosted on this platform. Nonetheless, our intentions are purely sympathetic and centered around preserving a piece of internet history.</p>
        <p><b>Purpose:</b><br>
        The primary objective of this website is to create a repository for tools, applications, games, audio, and software related to Windows Phone devices. We believe in the significance of maintaining these resources to facilitate accessibility and keep the memories alive for enthusiasts, researchers, and those who appreciate the Windows Phone ecosystem.</p>
        <p><b>Licensing Limitations:</b><br>
        It is crucial to acknowledge that we do not own the rights to the materials made available on this website. As such, we cannot provide any warranties or assurances regarding their legal status, accuracy, functionality, or compatibility with your specific Windows Phone device. We are unable to guarantee the authenticity, completeness, or timeliness of the content provided.</p>
        <p><b>Intellectual Property:</b><br>
        All intellectual property rights, including copyrights and trademarks, belong to their respective owners. Any logos, names, or brands displayed on this website are used for identification purposes only. We acknowledge and respect the ownership of these rights and encourage visitors to do the same.</p>
        <p><b>User Responsibility:</b><br>
        By using this website, you agree to assume full responsibility for any risks associated with downloading, installing, or using the materials provided. We strongly advise you to exercise caution and undertake your own due diligence before utilizing any content from our platform. It is your responsibility to ensure compliance with relevant laws, including copyright and licensing regulations, when interacting with the materials.</p>
        <p><b>Non-Endorsement:</b><br>
        The presence of any specific tools, applications, games, audio, or software on this website does not constitute an endorsement or recommendation by us. We do not guarantee the performance, security, or suitability of any content for your individual needs or preferences. Users should independently assess the suitability of the materials before utilizing them.</p>
        <p><b>Contact:</b><br>
        If you are a copyright holder or believe that any content on this website infringes upon your rights, please contact us at <a href="mailto:legal@windowsphone.online">legal@windowsphone.online</a>. We will make every effort to promptly address your concerns and resolve any legitimate issues.<br>
        For non-legal related questions, please email to <a href="mailto:postmaster@windowsphone.online">postmaster@windowsphone.online</a>. Note that our only official and maintained website is <a href="https://windowsphone.online">https://windowsphone.online</a>.</p>
        <p><b>Non-profit:</b><br>
        Please note that this website is non-profit. There are no advertisements or any form of monetization.</p>
        <p><b>Terms of use:</b><br>
        When using this website, you agree you will only download and install applications you obtained a license for in the past.
        <p><b>Contributors:</b></br>
        Is your material listed on this website and would you like your name displayed on this archive page and associated with Windows Phone Online? Please contact our postmaster address and mention the product you developed and your full name.</p><br>
        - <b>Dustin Hendriks</b> <small>(jetspiking)</small> | site maintainer <br>
    </div>
    ';

    // Define the directory path
    $directory = 'WinPhoneOnline/';
    
    // Function to scan the directory for files and subdirectories
    function scanDirectory($directory) {
        $fileList = [];
    
        // Open the directory
        if ($handle = opendir($directory)) {
            // Read directory entries
            while (($file = readdir($handle)) !== false) {
                if ($file != '.' && $file != '..') {
                    $filePath = $directory . $file;
                    $fileList[] = $filePath;
                }
            }
    
            // Close the directory
            closedir($handle);
        }
        sort($fileList);
        return $fileList;
    }
    
    // Function to recursively scan the directory for files and subdirectories based on search term
    function scanDirectoryRecursivelyForSearch($directory, $searchTerm) {
        $fileList = [];
    
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST,
            RecursiveIteratorIterator::CATCH_GET_CHILD
        );
    
        foreach ($iterator as $path => $file) {
            if ($file->isDir()) {
                $fileList[] = $path . '/';
            } else {
                // Check if the file name matches the search term
                if (strpos(strtolower($file->getFilename()), strtolower($searchTerm)) !== false) {
                    $fileList[] = $path;
                }
            }
        }
    
        return $fileList;
    }
    
    // Get the search term (if provided)
    $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
    
    // Check if a directory is clicked
    if (isset($_GET['dir'])) {
        $clickedDirectory = $_GET['dir'];
    
        // Validate and sanitize the clicked directory path
        $clickedDirectory = str_replace('..', '', $clickedDirectory);
        $clickedDirectory = rtrim($clickedDirectory, '/');
        $clickedDirectory = $directory . $clickedDirectory . '/';
    
        // Scan the clicked directory for files and subdirectories
        $files = scanDirectory($clickedDirectory);
    } else {
        // Scan the main directory for files and subdirectories
        $files = scanDirectory($directory);
    }
    
    // Filter files and directories based on search term
    if (!empty($searchTerm)) {
        $filteredFiles = scanDirectoryRecursivelyForSearch($directory, $searchTerm);
    
        // If no matching files or directories found, display a message
        if (empty($filteredFiles)) {
            echo '<p>No matching downloads found.</p>';
        }
    
        // Use filtered files and directories for display
        $files = $filteredFiles;
    
        // Filter directories from the search results
        $files = array_filter($files, function ($file) {
            return !is_dir($file);
        });
    }
    
    echo '<h1>Available Downloads</h1>';
    
    // Display the search form
    echo '
    <form method="GET" action="">
        <input type="text" name="search" placeholder="Search">
        <input type="submit" value="Search">
    </form>
    ';
    
    // Display the available downloads
    foreach ($files as $file) {
        if (is_dir($file)) {
            // Display the directory as a link
            $dirName = rtrim($file, '/');
            $dirName = str_replace($directory, '', $dirName);
            echo '<div class="download">';
            echo '<a href="?dir=' . urlencode($dirName) . '">' . $dirName . '</a>';
            echo '</div>';
        } else {
            // Display the file
            $filePath = $file;
            $fileSize = filesize($filePath);
            $fileDate = date("Y-m-d H:i:s", filemtime($filePath));
            $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
            $fileIcon = getFileIcon($fileExtension);
    
            echo '<div class="download">';
            echo '<a href="' . $filePath . '">' . $fileIcon . $filePath . '</a><br>';
            if ($fileSize < (1024*1024)) {
                echo '<p>Size: ' . round($fileSize / 1024) . ' KB<br>';
            } else {
                echo '<p>Size: ' . round($fileSize / 1024 / 1024) . ' MB<br>';
            }            
            echo 'Date: ' . $fileDate . '</p>';
            echo '</div>';
        }
    }
    
/**
 * Function to get file icon based on the file extension
 * Modify this function to suit your specific icon requirements
 *
 * @param string $fileExtension The file extension
 * @return string The HTML for the file icon
 */
function getFileIcon($fileExtension) {
    $icon = '';

    switch ($fileExtension) {
        case 'txt':
            $icon = '<i class="far fa-file-alt"></i> '; // Text file
            break;
        case 'jpg':
        case 'jpeg':
        case 'png':
        case 'gif':
            $icon = '<i class="far fa-file-image"></i> '; // Image file
            break;
        case 'pdf':
            $icon = '<i class="far fa-file-pdf"></i> '; // PDF file
            break;
        case 'doc':
        case 'docx':
            $icon = '<i class="far fa-file-word"></i> '; // Word document
            break;
        case 'xls':
        case 'xlsx':
            $icon = '<i class="far fa-file-excel"></i> '; // Excel spreadsheet
            break;
        case 'ppt':
        case 'pptx':
            $icon = '<i class="far fa-file-powerpoint"></i> '; // PowerPoint presentation
            break;
        case 'zip':
        case 'rar':
            $icon = '<i class="far fa-file-archive"></i> '; // Archive file
            break;
        case 'mp3':
        case 'wav':
            $icon = '<i class="far fa-file-audio"></i> '; // Audio file
            break;
        case 'mp4':
        case 'avi':
        case 'mov':
            $icon = '<i class="far fa-file-video"></i> '; // Video file
            break;
        case 'exe':
            $icon = '<i class="far fa-file-code"></i> '; // Executable file
            break;
        case 'xap':
        case 'appx':
            $icon = '<i class="far fa-file-alt"></i> '; // Windows Phone executable
            break;
        // Add more cases for different file extensions and corresponding icons
        default:
            $icon = '<i class="far fa-file"></i> '; // Default icon for unknown file types
            break;
    }

    return $icon;
}

?>
</body>
</html>
