<?php
session_start();
include_once '../commoninclude.php';
/*Session Timeout*/
if(isset($_SESSION['member']))
{
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 600))
    {
        // last request was more than 30 minates ago
        //session_destroy();   // destroy session data in storage
        //session_unset();     // unset $_SESSION variable for the runtime
        header("location:../logout.php");
    }
    $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
}
/*Ends here*/
$message = "";
$profileImage = "";
if (isset($_REQUEST['msg'])) {
    $message = "<span style='font-size: 1px;'>&nbsp;</span>";
    $message.="<div id='dvMessage'";
    $message.=" style='width: 100%;
                visibility: visible;
                display: block;
                text-align: right;
                padding: 4px;
                color:brown;
                font-family: verdana;
                font-size: 12px;
                background-color: #B8ADF1;'>";
    $message.= "Stuff added successfully.";
    $message.="</div><span style='font-size: 1px;'>&nbsp;</span>";
} else {
    $message = "<span style='font-size: 1px;'>&nbsp;</span>";
    $message.="<div id='dvMessage'";
    $message.=" style='width: 100%;
                visibility: hidden;
                display: none;
                text-align: right;
                padding: 4px;
                color:brown;
                font-family: verdana;
                font-size: 12px;
                background-color: #B8ADF1;'>";
    $message.="</div><span style='font-size: 1px;'>&nbsp;</span>";
}
if(isset($_SESSION['member']))
{
    //Business Object
    $objBoMemberProfile = new BoMemberProfile();
    $objBoMemberProfile->setMemberId($_SESSION['memberid']);
    //Presentation Layer Object
    $objPlMember = new PlMemberProfile();
    $record = $objPlMember->PlGetMemberProfileDetails($objBoMemberProfile);
    $profileImage = isset($record[0]['ProfileImagePath']) ? addslashes('../Member/MemberImages/' . $record[0]['ProfileImagePath']) : addslashes('../Member/MemberImages/Default.jpg');
}
/* Browsing Stuff Here */
if(!isset($_REQUEST['tag'])) $_SESSION['tag']="All";
else $_SESSION['tag']=$_REQUEST['tag'];

if(isset($_REQUEST['filter']))
    $filter=$_REQUEST['filter'];
else
    $filter="";

//Pagination Class
$_SESSION['currentpagelimit']=$_SESSION['TotalRecordsOnBrowseCategoryPage'];
$pages = new Paginator();
$objPlBrowseStuff=new PlStuff();

$num_rows=$objPlBrowseStuff->PlBrowseCategoryStuffTotalRecords($_REQUEST['categoryid'],$filter);
if($num_rows>0)
{
    $pages->items_total = $num_rows;
    $pages->paginate();
}
$limit=$pages->limit;
$output = $objPlBrowseStuff->PlBrowseCategoryStuff($_REQUEST['categoryid'],$limit,$filter);
/* Browsing Stuff Ends Here */

/* Display All Tags */
$objPlTag=new PlTags();
$alltagslist=$objPlTag->PlDisplayAllTags();
/* Ends here*/

/* Displaying Categories */
//$objPlCategory=new PlCategory();
//$relatedCategoryList=$objPlCategory->PlShowCategories(10);
$relatedCategoryList="";
/* Ends here*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="rtl" lang="he" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title></title>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
        <style type="text/css">

            body
            {
                background-color: #495863;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            div#dvMain
            {
                padding: 0;
                margin: 0 auto;
                width: 982px;
                height: auto;
                background-color: #FFFFFF;
                border-style: solid;
                border-width: thick;
                border-color:#1c2e3c;
                font-family: Verdana, Arial, Helvetica, sans-serif;
                font-size: 13px;
                margin-left: auto;
                margin-right: auto;
            }
            #dvBanner
            {
                position: relative;
                width: 982px;
                height: 125px;
                display:block;
                padding: 0px;
                background-image: url(../images/logoheader.jpg);
                background-repeat: no-repeat;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            #dvLogin
            {
                position: relative;
                float: left;
                display: block;
                top: 30px;
                left: 390px;
                color: white;
                font-size: 14px;
                font-weight: bold;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            #dvLogin a
            {
                text-decoration: none;
                color:white;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            #dvLogin a:hover
            {
                text-decoration: underline;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            /*If Member not logged in*/
            #dvNotLogin
            {
                position: relative;
                float: left;
                display: block;
                top: 30px;
                left: 450px;
                color: white;
                font-size: 14px;
                font-family: Verdana, Arial, Helvetica, sans-serif;
                font-weight: bold;
            }
            #dvNotLogin a
            {
                text-decoration: none;
                color:white;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            #dvNotLogin a:hover
            {
                text-decoration: underline;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            .spNotAMember
            {
                color: #f9c60b;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            #dvMenuStrip
            {
                position: relative;
                top: 80px;
                width: 982px;
                height: 30px;
                z-index: 3;
                display:block;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            #dvMenuContents
            {
                position: relative;
                width: 982px;
                top: 3px;
                left: 300px;
                float: right;
                color: black;
                display: block;
                font-size: 15px;
                font-weight: bold;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            #dvMenuContents a
            {
                text-decoration: none;
                color: black;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            #dvMenuContents a:hover
            {
                color: white;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            #dvBrowseOrAddNewStuff
            {
                display: block;
                float: left;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            #dvMessage
            {
                width: 100%;
                visibility: hidden;
                display: none;
                text-align: right;
                padding: 4px;
                color:brown;
                font-family: Verdana, Arial, Helvetica, sans-serif;
                font-size: 12px;
                background-color: #B8ADF1;
            }
            #dvAddStuffButton
            {
                position: relative;
                float:left;
                top: -17px;
                left: 140px;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            #dvBrowseStuffButton
            {
                position: relative;
                float: left;
                top: -17px;
                display: block;
                left: -170px;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            #dvMessage
            {
                width: 980px;
                visibility: hidden;
                height:15px;
                display: none;
                text-align: right;
                color:brown;
                font-family: Verdana, Arial, Helvetica, sans-serif;
                font-size: 12px;
                background-color: #B8ADF1;
            }
            #dvAddStuff
            {
                /*position: absolute;
                top:100px;
                left:2px;*/
                visibility: hidden;
                width: 980px;
                height: auto;
                z-index: 4;
                border-style: solid;
                border-width: thin;
                border-color:#1b4376;
                margin-left:auto;
                margin-right:auto;
                padding-top: 10px;
                padding-bottom: 10px;
                display:none; /*Maha Gilinder*/
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            #dvAdsAndMessage
            {
                width: 982px;
                display: block;
                height: 90px;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }

            #dvAd1
            {
                position: relative;
                float: left;
                top: 3px;
                left: 10px;
                width: 650px;
                border-width: thin;
                border-style: solid;
                display: block;
                height: 78px;
                background-image: url(../images/ad1.jpg);
                background-repeat: no-repeat;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }

            #dvBecameFriends
            {
                position: relative;
                float: right;
                top: 3px;
                right: 5px;
                width: 300px;
                border-width: thin;
                border-style: solid;
                display: block;
                font-family: Verdana, Arial, Helvetica, sans-serif;
                height: 78px;
                background-image: url(../images/becamefriends.jpg);
                text-align: center;
            }
            #dvMainContent
            {

                float: right;
                width: 982px;
                /*border-width: thin;
                border-style: solid;*/
                display: block;
                height: auto;
                text-align: right;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }

            #dvBrowseStuff
            {
                width: 680px;
                /*border-width: thin;
                border-style: solid;*/
                display: table;
                padding: 4px;
                height: auto;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            /*Stuff Detail Section*/
            #dvRightColumn
            {
                position: relative;
                top: 2px;
                width: 650px;
                right: 6px;
                float: right;
                /*border-width: thin;
                border-style: solid;*/
                display: block;
                height: auto;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            #dvStuffTitle
            {
                position: relative;
                width: 640px;
                /*border-width: thin;
                border-style: solid;*/
                display: block;
                height: 32px;
                top:2px;
                background-image: url(../images/browseallstufftitle.jpg);
                background-repeat: no-repeat;
                padding-top: 5px;
                color: #FFFFFF;
                font-family: Verdana, Arial, Helvetica, sans-serif;
                font-weight: bold;
                font-size: 14px;
                text-align: right;
            }           
            
            #dvFilterSection
            {
                position: relative;
                float: right;
                right: 4px;
                width: 640px;
                /*border-width: thin;
                border-style: solid;*/
                display: block;
                height: 25px;
                top: 5px;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            #dvFilters
            {
                position: relative;
                float: right;
                width:270px;
                display: block;
                height: auto;
                text-align: right;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            #dvFilters a
            {
                text-decoration: none;
            }
            #dvFilters a:hover
            {
                text-decoration: underline;
            }
            #dvTopPaging
            {
                position: relative;
                float:left;
                width: 340px;
                display: block;
                height: auto;
                text-align: left;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            #dvStuffDetails
            {
                position: relative;
                float: right;
                right: 4px;
                width: 640px;
                /*border-width: thin;
                border-style: solid;*/
                display: table;
                height: auto;
                top: 10px;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            #dvBottomPaging
            {
                position: relative;
                float: left;
                left: 4px;
                width: 640px;
                display: inline-block;
                /*border-width: thin;
                border-style: solid;*/
                height: 25px;
                text-align: left;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            /*Left Column Section */
            #dvLeftColumn
            {
                position: relative;
                float: left;
                top: 2px;
                left:8px;
                width:300px;
                height: auto;
                display: block;
                /*border-style: solid;
                border-width: thin;*/
                border-color:#1b4376;
                margin-left:auto;
                margin-right:auto;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            #dvAd2
            {
                position: relative;
                top: 2px;
                width: 290px;
                height: 230px;
                border-style: solid;
                border-width: thin;
                border-color:#1b4376;
                background-image: url(../images/ad2.png);
                background-repeat: no-repeat;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            /* Display All Tags*/
            #dvAllTags
            {
                position: relative;
                top: 2px;
                width: 290px;
                height: auto;
                font-family: Verdana, Arial, Helvetica, sans-serif;
                /*border-style: solid;
                border-width: thin;
                border-color:#1b4376;*/
            }
            #dvAllTagsTitle
            {
                background-image: url(../images/RelatedCategoryTitle.jpg);
                background-repeat: no-repeat;
                height: 32px;
                /*border-width: thin;
                border-style: solid;*/
                text-align: right;
                color: black;
                font-family: Verdana, Arial, Helvetica, sans-serif;
                font-size: 14px;
                color: #FFFFFF;
                font-weight: bold;
                padding-right: 5px;
                padding-top: 6px;
            }
            #dvAllTagsList
            {
                /*border-width: thin;
                border-style: solid;*/
                display: table;
                width: 270px;
                height: auto;
                text-align: right;
                font-family: Verdana, Arial, Helvetica, sans-serif;
                font-size: 12px;
            }
            #dvAllTagsList a
            {
                text-decoration: none;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            /* Ends here*/
            /*Related Category*/
            #dvRelatedCategory
            {
                position: relative;
                top: 2px;
                width: 290px;
                height: auto;
                font-family: Verdana, Arial, Helvetica, sans-serif;
                /*border-style: solid;
                border-width: thin;
                border-color:#1b4376;*/
            }
            #dvRelatedCategoryTitle
            {
                background-image: url(../images/RelatedCategoryTitle.jpg);
                background-repeat: no-repeat;
                height: 32px;
                /*border-width: thin;
                border-style: solid;*/
                text-align: right;
                color: black;
                font-family: Verdana, Arial, Helvetica, sans-serif;
                font-size: 11px;
                color: #FFFFFF;
                font-weight: bold;
                padding-right: 5px;
                padding-top: 6px;
            }
            #dvCategoryList
            {
                /*border-width: thin;
                border-style: solid;*/
                display: block;
                width: 270px;
                height: auto;
                text-align: right;
                font-family: Verdana, Arial, Helvetica, sans-serif;
                font-size: 12px;
            }
            #dvCategoryList a
            {
                text-decoration: none;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            /*Ends here*/
            div#dvFooter
            {
                width: 982px;
                z-index: 4;
                padding-top: 20px;
                display:block;
                padding: 4px;
                direction: rtl;
                text-align: center;
                font-size: 13px;
                font-family: Verdana, Arial, Helvetica, sans-serif;
                color: #FFFFFF;
                margin-left: auto;
                margin-right: auto;

            }
            #dvFooter a
            {
                font-size: 13px;
                font-family: Verdana, Arial, Helvetica, sans-serif;
                color: #FFFFFF;
                text-decoration: none;
            }
            #dvFooter a:hover
            {
                text-decoration: underline;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            .table
            {
                font-family: Verdana, Arial, Helvetica, sans-serif;
                font-size: 12px;
                /*border-style: solid;
                border-width: thin;*/
            }
            .smalltagname
            {
                font-family: Verdana, Arial, Helvetica, sans-serif;
                font-size: 9px;
            }
        </style>

        <!--Paging-->
        <style type="text/css">
        .paginate {
                font-family: Arial, Helvetica, sans-serif;
                font-size: .7em;
        }

        a.paginate {
                border: 1px solid #000080;
                padding: 2px 6px 2px 6px;
                text-decoration: none;
                color: #000080;
        }


        a.paginate:hover {
                background-color: #000080;
                color: #FFF;
                text-decoration: underline;
        }

        a.current {
                border: 1px solid #000080;
                font: bold .7em Arial,Helvetica,sans-serif;
                padding: 2px 6px 2px 6px;
                cursor: default;
                background:#000080;
                color: #FFF;
                text-decoration: none;
        }

        span.inactive {
                border: 1px solid #999;
                font-family: Arial, Helvetica, sans-serif;
                font-size: .7em;
                padding: 2px 6px 2px 6px;
                color: #999;
                cursor: default;
        }

        /*table {
                margin: 8px;
        }

        th {
                font-family: Arial, Helvetica, sans-serif;
                font-size: .7em;
                background: #666;
                color: #FFF;
                padding: 2px 6px;
                border-collapse: separate;
                border: 1px solid #000;
        }

        td {
                font-family: Arial, Helvetica, sans-serif;
                font-size: .7em;
                border: 1px solid #DDD;
        }*/
        </style>
        <script type="text/javascript" language="JavaScript">
        function hilite(elem)
        {
                elem.style.background = '#FFC';
        }

        function lowlite(elem)
        {
                elem.style.background = '';
        }
        </script>
        <!--Paging-->

        <script type="text/javascript" language="JavaScript">
            var i=1;
            String.prototype.trim = function()
            {
                return this.replace(/(?:(?:^|\n)\s+|\s+(?:$|\n))/g,"");
            }
            function StuffValid()
            {
                if(document.frmaddstuff.txtStuffName.value.trim()=="")
                {
                    document.getElementById("dvMessage").style.visibility="visible";
                    document.getElementById("dvMessage").style.display="block";
                    document.getElementById("dvMessage").innerHTML="Stuff cannot be blank.";
                    return false;
                }
                else
                    document.getElementById("dvMessage").innerHTML="";
                document.getElementById("dvMessage").style.display="block";
                return true;
            }
            function DisplayAddStuff()
            {
                if(i==1)
                {
                    document.getElementById("dvAddStuff").style.visibility="visible";
                    document.getElementById("dvAddStuff").style.display="table";
                    i=0;
                }
                else
                {
                    document.getElementById("dvAddStuff").style.visibility="hidden";
                    document.getElementById("dvAddStuff").style.display="none";
                    i=1;
                }
            }
            function DisplayAddCategory()
            {
                if(i==1)
                {
                    document.getElementById("dvAddCategory").style.visibility="visible";
                    document.getElementById("dvAddCategory").style.display="table";
                    i=0;
                }
                else
                {
                    document.getElementById("dvAddCategory").style.visibility="hidden";
                    document.getElementById("dvAddCategory").style.display="none";
                    i=1;
                }
            }

        </script>
    </head>
    <body>
        <div id="dvMain" align="center">
            <div id="dvBanner">
                <?php
                if (isset($_SESSION['member'])) {
                ?>
                    <div id="dvLogin">
                        <!--<img src='<?php //echo $profileImage; ?>' width='20px' height='20px' alt='' />-->
                        <a href="../logout.php" title="Logout"> logout </a> |
                        <a href="../Member/Comments.php" title="Comments"> comments </a>|
                        <a href="../Member/Stuffs.php" title="Stuffs"> stuff </a> |
                        <a href="../Member/Profile.php" title="Member Profile"><?php echo $_SESSION['member']; ?></a>
                    </div>
                    <div style="position: absolute;float:left;left: 875px;width: 105px;height: 120px;">
                        <a href="../index.php" style="outline: none;">
                            <img src="../images/hotspot.png" border="0" alt=""/>
                        </a>
                    </div>
                <?php
                } else {
                ?>
                    <div id="dvNotLogin">
                        <!--<img src='member/memberimages/default.jpg' width='20px' height='20px' alt='' />|-->
                        <a href="../Member/Login.php" title="Login">התחבר</a> |
                        <span class="spNotAMember" title="Not a Member">עדיין לא רשום ?</span>
                        <a href="../Member/Signup.php" title="Sign Up"> הרשם עכשיו </a>
                    </div>
                    <div style="position: absolute;float:left;left: 875px;width: 105px;height: 120px;">
                        <a href="../index.php" style="outline: none;">
                            <img src="../images/hotspot.png" border="0" alt=""/>
                        </a>
                    </div>
                <?php
                       }
                ?>
                <div style="clear: both;"></div>
                <div id="dvMenuStrip">
                    <div id='dvMenuContents'>
                        <a href="../index.php" title="HOME"><?php echo MENU_HOME; ?></a> <a href="#" title="FAQ"><?php echo FAQ; ?></a>
                    </div>
                    <div id="dvAddStuffButton">
                        <a href="#" onclick="DisplayAddStuff();"> <img id="btnAddStuff" name="btnAddStuff" src='../images/AddStuff.png' width='175px' height='24px' alt='' border="0"/></a>
                    </div>
                    <div id="dvBrowseStuffButton">
                        <a href="../Stuff/BrowseStuff.php?page=1&ipp=<?php echo $_SESSION['TotalRecordsOnBrowseStuffPage']; ?>"><img id="btnBrowser" name="btnBrowse" src='../images/BrowseStuff.png' width='130px' height='24px' alt='' border="0"/></a>
                    </div>
                    <div style="clear: both;"></div>
                </div>
            </div>
            <span style='font-size: 1px;'>&nbsp;</span>
            <!--Add Stuff Section-->
            <div id="dvAddStuff"><span style='font-size: 1px;'>&nbsp;</span>
                <form action="../Stuff/AddMyStuff.php" method="POST" name="frmaddstuff" onsubmit="return StuffValid();">
                    <table class="table" align="Right" width="300px">
                        <tr>
                            <td colspan="2">Stuff Title:</td>
                        </tr>
                        <tr>
                            <td><input type="text" id="txtStuffName" name="txtStuffName" size="40"/></td>
                            <td align="left"><input type="submit" name="submit" id="submit" value="Add"/></td>
                        </tr>
                    </table>
                </form>
                <div style="float: left;"><a href='#' onclick="DisplayAddStuff();">Close</a></div>
            </div>
            <!--Add Stuff Form ends here-->
            <!--Ads and Friends Section-->
            <div id="dvAdsAndMessage">
                <div id="dvAd1">
                    Ads goes here
                </div>
                <div id="dvBecameFriends">
                    &nbsp;
                    <?php
		    $objPlStuff=new PlStuff();
                    $LastFriends=$objPlStuff->PlLastFriend();
		    echo $LastFriends;
                    /*$objPlLastFriend=new PlStuff();
                    $LastFriends=$objPlLastFriend->PlLastFriend();
                    if(isset($LastFriends))
                    {
                        echo "<a href='../Member/Profile.php?id=".$LastFriends[0][0]['ID']."&member=".$LastFriends[0][0]['NickName']."'><img src='../member/memberimages/".$LastFriends[0][0]['ProfileImagePath']."' style='width:12px;height:12px;border:1px;' alt=''/> ".$LastFriends[0][0]['NickName']."</a> and <br/>";
                        echo "<a href='../Member/Profile.php?id=".$LastFriends[1][0]['ID']."&member=".$LastFriends[1][0]['NickName']."'><img src='../member/memberimages/".$LastFriends[1][0]['ProfileImagePath']."' style='width:12px;height:12px;border:1px;' alt=''/> ".$LastFriends[1][0]['NickName']."</a> are now Friends";
                    }*/
                    ?>
                </div>
            </div>
            <!--Ads and Message ends here-->
            <div style="clear: both;"></div>
            <!--Browse Stuff Details Right Column-->
            <div id="dvRightColumn">
                <div id="dvStuffTitle">
                    &nbsp;&nbsp;&nbsp;<?php echo $_REQUEST['categoryname']; ?>
                </div>
                <div style="clear:both;"></div>
                <span style='font-size: 1px;'>&nbsp;</span>
                <div id="dvFilterSection">
                    <div id="dvFilters">
                        <a href="BrowseCategory.php?page=1&ipp=20&filter=created&categoryid=<?php echo $_REQUEST['categoryid']."&categoryname=".$_REQUEST['categoryname']; ?>">created</a>
                        <a href="BrowseCategory.php?page=1&ipp=20&filter=popular&categoryid=<?php echo $_REQUEST['categoryid']."&categoryname=".$_REQUEST['categoryname']; ?>">popular</a>
                        <a href="BrowseCategory.php?page=1&ipp=20&filter=active discussion&categoryid=<?php echo $_REQUEST['categoryid']."&categoryname=".$_REQUEST['categoryname']; ?>">active discussions</a>
                    </div>
                    <div id="dvTopPaging">
                        <?php
                            if($num_rows>0)
                            {
                                echo $pages->display_pages();
                            }
                        ?>
                    </div>
                </div>
                <div style="clear:both;"></div>
                <span style='font-size: 1px;'>&nbsp;</span>
                <!--Stuff Listing-->
                <div id="dvStuffDetails">
                    <?php
                        echo $output;
                    ?>                    
                </div>
                <div style="clear:right;"></div>
                <div id="dvBottomPaging">
                    <br/>
                    <?php
                        if($num_rows>0)
                        {
                            echo $pages->display_pages();
                        }
                    ?>
                </div>
                <font color="white">fjsdl</font>
            </div>
            <!--Ads and Related Category Left Column-->
            <div id="dvLeftColumn">
                <div id="dvAd2">
                    Ads goes here
                </div>
                <span style='font-size: 1px;'>&nbsp;</span>
                <!--<div id="dvAllTags">
                    <div id="dvAllTagsTitle">
                        Tags
                    </div>
                    <div id="dvAllTagsList">
                        <?php
                            /*if(isset($alltagslist))
                                echo $alltagslist;*/
                        ?>
                    </div>
                </div>-->
                <span style='font-size: 1px;'>&nbsp;</span>
                <span style='font-size: 1px;'>&nbsp;</span>
                <div id="dvRelatedCategory">
                    <?php if(isset($relatedCategoryList)) {?>
                    <div id="dvRelatedCategoryTitle">
                        Related Categories
                    </div>
                    <div id="dvCategoryList">
                        <?php
                            if(isset($relatedCategoryList))
                                echo $relatedCategoryList;
                        ?>                        
                    </div>
                    <?php } ?>
                </div>
                <span style='font-size: 1px;'>&nbsp;</span>
                <span style='font-size: 1px;'>&nbsp;</span>
            </div>
            <div style="clear: both;"></div>
            <!--Left Column ends here-->
        </div><!--Main Div ends here-->
        <span style='font-size: 1px;'>&nbsp;</span>
        <div id='dvFooter' align="center">
            <!--<a href="#">home |</a> <a href="#">faq |</a>
            <a href="#">privacy policy |</a> <a href="#">term and conditions |</a>
            <a href="#">contact us |</a> <a href="#">rss feed |</a> <a href="#">bookmark this page</a><br/>
            Copyright &copy;2010 Avigabso. Designed & Developed by <a href="http://themacrosoft.com">Macrosoft Solutions</a>-->
	    <?php include_once('../footers.php'); ?>
        </div>
    </body>
</html>
