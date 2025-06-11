
<?php
include "head.php";

?>

<?php
get_mess();
$root_path = $_SESSION['root_path'];
$dir='1';
//echo $root_path;
if(isset($_GET['p'])){$last_url='?p='.Get_last_folder($_GET['p']);}
else{$last_url='index.php';}
?>
<div class="container"> 
    <?php
    if(isset($_GET['p'])){Get_all_url($_GET['p']);}else{Get_all_url('');}
    if(isset($_GET['p'])){$url_z=$_GET['p'];}else{$url_z='';}
    ?>
    <table class='table' border="1">
        <thead>
            <tr>
                <td scope='col' colspan='2'><a href='<?php echo $last_url; ?>' ><i class='icon-goback'></i>Назад</a></td>
                <td scope='col'></td>
                <td scope='col'>
                    <a href='?p=<?php echo $url_z;?>&o=upload' ><i class='icon-upload'></i>Загрузить файл</a> | 
                    <a href='?p=<?php echo $url_z;?>&o=newFolder' ><i class='icon-folder_add'></i>Создать папку</a>
                </td>  
            </tr>
        </thead>
    </table>
<?php
    //отображение всех файлов
    if(!isset($_GET['o']))
    {
    Get_All_file($root_path);
    }
    
    //создание папки
    if(isset($_GET['o']) && isset($_GET['p']) && $_GET['o']=='newFolder')
    {
        Creat_folder($root_path);
    }
    
    
    //загрузка файла
    if(isset($_GET['o']) && isset($_GET['p']) && $_GET['o']=='upload')
    {
        $ok='';
        if($_GET['p']==''){$folder="/";}else{$folder=$_GET['p'];}
        if(isset($_GET['ok']) && $_GET['ok']==true){$ok=true;}else{$ok==false;}
        Upload_file($folder, $ok, $root_path);
    }
    
    //удаление файла
    if(isset($_GET['o']) && isset($_GET['p']) && $_GET['o']=='dell')
    {
    Dell_file($_GET['p']);
    }
    
    //переименование
    
    //поделиться
?>
</div>

</body>
</html>

<?php
//получить весь путь
function Get_all_url($url)
{
    $array = explode("/", $url);
    echo '
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="index.php">Главная</a></li>
    ';
    $url1='';
    for($i=0; $i<count($array); $i++)
    {
        if($i==0){$url1=$array[$i];}
        else{$url1=$url1."/".$array[$i];}
        if($i==(count($array)-1))
        {
            $activ='active';
            $url2=$array[$i];
        }
        else
        {
            $activ='';
            $url2='<a href="?p='.$url1.'">'.$array[$i].'</a>';
        }
       
        echo'
        <li class="breadcrumb-item '.$activ.'">'.$url2.'</li>
        ';
    }
    echo'
    </ol>
    </nav>
    ';
    
}


//получить путь до предыдущей папки
function Get_last_folder($url)
{
    $array = explode("/", $url);
    $url1='';
        for($i=0; $i<count($array)-1; $i++)
        {
            if($i==0)
            {
                if($array[$i]==$_SESSION['username']){$url1='';}
                else{$url1=$array[$i];}
            }
            else{$url1=$url1."/".$array[$i];}
        }
    return $url1;
}

//Создание папки 
function Creat_folder($root)
{
        if(isset($_GET['add'])){
            echo "new";
            if (!file_exists($root.'/'.$_GET['p'].'/'.$_GET['newfolder'])) {
                mkdir($root.'/'.$_GET['p'].'/'.$_GET['newfolder'], 0777, true);
                set_mess('Каталог <b>'.$_GET['newfolder'].'</b> создан!', 'success');
                 echo '<meta http-equiv="refresh" content="0;url=?p='.$_GET['p'].'">';
            }
            else{
                set_mess('Ой, не получилось!', 'danger');
                echo '<meta http-equiv="refresh" content="0;url=?p='.$_GET['p'].'">';
            }
            
        }
        else{
         echo '
    <form action="" method="get">
        <div class="mb-3">
            <label for="folderName" class="form-label">Название папки</label>
             <input type="hidden" name="p" value="'.$_GET["p"].'">
            <input type="hidden" name="o" value="newFolder">
            <input type="hidden" name="add" value="yes">
            <input type="hidden" name="url" value="'.$_GET["p"].'">
            <input type="text" name="newfolder" class="form-control" value="Новая папка" id="folderName" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">Введите название папки.</div>
        </div>
        <button type="submit" class="btn btn-primary">Создать</button>
    </form>';
        }
    
}


//вывод всех файлов
function Get_All_file($root_path)
{
    //clearstatcache();
    //вывод файлов
    if(isset($_GET['p']))
    {
        $dir_scan=$root_path."/".$_GET['p'];
        $p=$_GET['p'];
    }
    else
    {
        $dir_scan=$root_path; 
        $p='';
    }
    //echo "<br>".$dir_scan;
    $files1 = scandir($dir_scan);
    //print_r($files1);
    //echo "<br>";
    //echo count($files1);
   // echo "<br>";
    //echo $files1[5];
    echo "
    <table class='table' border='1'>
        <thead>
            <tr>
                <th scope='col'></th>
                <th scope='col'>Имя</th>
                <th scope='col'>Размер</th>
                <th scope='col'>Дата</th>
                <th scope='col'>Действия</th>
            </tr>
        </thead>
    <tbody>";

    if(count($files1)>2)
    {
    for($i=2; $i<count($files1); $i++)
    {
        if(is_dir($dir_scan.'/'.$files1[$i]))
        {
            if($p==''){$p='';}else{$p=$p."/";}
            echo '
            <tr>
            <th scope="row"><input type="checkbox" name="'.$files1[$i].'" value="1" /></th>
            <td><i class="icon-folder"></i><a href="?p='.$p.''.$files1[$i].'" >'.$files1[$i].'</a></td>
            <td>'.convert_bytes(filesize($dir_scan.'/'.$files1[$i])).'</td>
            <td>'.date("d.m.y H:i", filemtime($dir_scan."/".$files1[$i])).'</td>
            <td>
                <div class="btn-group" role="group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Действия
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="?p='.$dir_scan.'/'.$files1[$i].'&o=dell&tep=1"><i class="icon-cancel"></i>Удалить</a></li>
                    <li><a class="dropdown-item" href="?p='.$dir_scan.'/'.$files1[$i].'&o=rename"><i class="icon-rename"></i>Переименовать</a></li>
                    <li><a class="dropdown-item" href="share.php?p='.$dir_scan.'/'.$files1[$i].'&o=link"><i class="icon-link_folder"></i>Поделиться</a></li>
                </ul>
                </div>
            </td>
            </tr>';
        }
    }
        for($i=2; $i<count($files1); $i++)
        {
            if(is_file($dir_scan.'/'.$files1[$i])){
               // pathinfo($url, PATHINFO_EXTENSION);
            echo '
            <tr>
            <th scope="row"><input type="checkbox" name="'.$files1[$i].'" value="1" /></th>
            <td><a href="user1/'.$p.'/'.$files1[$i].'" target="_blank"><i class="'.get_file_icon_class($p.'/'.$files1[$i]).'"></i>'.$files1[$i].'</a></td>
            <td>'.convert_bytes(filesize($dir_scan.'/'.$files1[$i])).'</td>
            <td>'.date("d.m.y H:i", filemtime($dir_scan.'/'.$files1[$i])).' </td>
            <td>
                <div class="btn-group" role="group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Действия
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="?p='.$dir_scan.'/'.$files1[$i].'&o=dell&tep=1"><i class="icon-cancel"></i>Удалить</a></li>
                    <li><a class="dropdown-item" href="?p='.$dir_scan.'/'.$files1[$i].'&o=rename"><i class="icon-rename"></i>Переименовать</a></li>
                    <li><a class="dropdown-item" href="?p='.$dir_scan.'/'.$files1[$i].'&o=copy"><i class="icon-copy"></i>Скопировать</a></li>
                    <li><a class="dropdown-item" href="share.php?p='.$dir_scan.'/'.$files1[$i].'&o=link"><i class="icon-link_file"></i>Поделиться</a></li>
                </ul>
                </div>
            </td>
            </tr>';
            }
        }
    }
    else{
        echo"<tr>
            <th scope='row'></th>
            <td ></td>
            <td></td>
            </tr>";
    }
      echo "</tbody>
</table>";
}

//получить иконку файла
function get_file_icon_class($path)
{
    // get extension
    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

    switch ($ext) {
        case 'ico': case 'gif': case 'jpg': case 'jpeg': case 'jpc': case 'jp2':
        case 'jpx': case 'xbm': case 'wbmp': case 'png': case 'bmp': case 'tif':
        case 'tiff':
            $img = 'icon-file_image';
            break;
        case 'txt': case 'css': case 'ini': case 'conf': case 'log': case 'htaccess':
        case 'passwd': case 'ftpquota': case 'sql': case 'js': case 'json': case 'sh':
        case 'config': case 'twig': case 'tpl': case 'md': case 'gitignore':
        case 'less': case 'sass': case 'scss': case 'c': case 'cpp': case 'cs': case 'py':
        case 'map': case 'lock': case 'dtd':
            $img = 'icon-file_text';
            break;
        case 'zip': case 'rar': case 'gz': case 'tar': case '7z':
            $img = 'icon-file_zip';
            break;
        case 'php': case 'php4': case 'php5': case 'phps': case 'phtml':
            $img = 'icon-file_php';
            break;
        case 'htm': case 'html': case 'shtml': case 'xhtml':
            $img = 'icon-file_html';
            break;
        case 'xml': case 'xsl': case 'svg':
            $img = 'icon-file_code';
            break;
        case 'wav': case 'mp3': case 'mp2': case 'm4a': case 'aac': case 'ogg':
        case 'oga': case 'wma': case 'mka': case 'flac': case 'ac3': case 'tds':
            $img = 'icon-file_music';
            break;
        case 'm3u': case 'm3u8': case 'pls': case 'cue':
            $img = 'icon-file_playlist';
            break;
        case 'avi': case 'mpg': case 'mpeg': case 'mp4': case 'm4v': case 'flv':
        case 'f4v': case 'ogm': case 'ogv': case 'mov': case 'mkv': case '3gp':
        case 'asf': case 'wmv':
            $img = 'icon-file_film';
            break;
        case 'eml': case 'msg':
            $img = 'icon-file_outlook';
            break;
        case 'xls': case 'xlsx':
            $img = 'icon-file_excel';
            break;
        case 'csv':
            $img = 'icon-file_csv';
            break;
        case 'doc': case 'docx':
            $img = 'icon-file_word';
            break;
        case 'ppt': case 'pptx':
            $img = 'icon-file_powerpoint';
            break;
        case 'ttf': case 'ttc': case 'otf': case 'woff':case 'woff2': case 'eot': case 'fon':
            $img = 'icon-file_font';
            break;
        case 'pdf':
            $img = 'icon-file_pdf';
            break;
        case 'psd':
            $img = 'icon-file_photoshop';
            break;
        case 'ai': case 'eps':
            $img = 'icon-file_illustrator';
            break;
        case 'fla':
            $img = 'icon-file_flash';
            break;
        case 'swf':
            $img = 'icon-file_swf';
            break;
        case 'exe': case 'msi':
            $img = 'icon-file_application';
            break;
        case 'bat':
            $img = 'icon-file_terminal';
            break;
        default:
            $img = 'icon-document';
    }

    return $img;
}

//метод загрузки файла
function Upload_file($folder, $ok, $root_path)
{
    if($folder=='/'){$url='Главная';}else{$url=$folder;}
    //если файл выбран и нажата загрузка
    if($ok==true)
    {
        // Директория куда будут загружаться файлы.
        $path =$root_path."/".$folder;
        if($_FILES)
        {
            foreach ($_FILES["file"]["error"] as $key => $error) 
            {
                if ($error == UPLOAD_ERR_OK) 
                {
                    $tmp_name = $_FILES["file"]["tmp_name"][$key];
                    $name = $_FILES["file"]["name"][$key];
                    move_uploaded_file($tmp_name, $path."/".$name);
                    set_mess('Файл(ы) успешно загружены!', 'success');
                }
                else
                {
                    set_mess('Ой, не получилось!', 'danger');
                }
            }
            echo '<meta http-equiv="refresh" content="0;url=?p='.$folder.'">';
        }
    }
    //если файл не выбран и не нажата загрузка
    if($ok!=true)
    {
        echo '
        <form action="?p='.$folder.'&o=upload&ok=true" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="folderName" class="form-label">Загрузка файла в <b>'.$url.'</b></label>
                <input type="hidden"  name="p" value="'.$folder.'">
                <input type="hidden" name="o" value="upload">
                <input type="hidden" name="ok" value="true">
                <input class="form-control" name="file[]" type="file" id="formFileMultiple" multiple>
                <div id="formFileMultiple" class="form-text">Выберите файл для загрузки...</div>
            </div>
            <button type="submit" class="btn btn-primary">Загрузить</button>
        </form>';   
    }
}


//Удалить файл/дирректорию
function Dell_file($file)
{
    if(is_file($file))
    {
        if (unlink($file))
        echo "Файл удален";
        else echo "Ошибка при удалении файла";
    }
    if(is_dir($file))
    {
        
        if(rmdir("newdir"))
    echo "Каталог удален";
else
    echo "Ошибка при удалении каталога";
    }
}

?>

