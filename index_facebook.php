<?php
session_start();
set_time_limit(0);
include_once 'commoninclude.php';
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 600))
{
    // last request was more than 30 minates ago
    //session_destroy();   // destroy session data in storage
    //session_unset();     // unset $_SESSION variable for the runtime
    header("location:logout.php");
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

$profileImage="";
if(isset($_SESSION['member']))
{
    //Business Object
    $objBoMemberProfile = new BoMemberProfile();
    $objBoMemberProfile->setMemberId($_SESSION['memberid']);

    //Presentation Layer Object
    $objPlMember = new PlMemberProfile();
    $record = $objPlMember->PlGetMemberProfileDetails($objBoMemberProfile);
    $profileImage = isset($record[0]['ProfileImagePath']) ? 'Member/MemberImages/' . $record[0]['ProfileImagePath'] : 'Member/MemberImages/Default.jpg';
}

//Collage Image Section
$objPlCollage=new PlStuff();
$showCollage=$objPlCollage->PlShowCollageOnHome(165);
//Ends here

//Stuff Section
$objPlStuff=new PlStuff();
$showStuffs=$objPlStuff->PlShowStuffOnHome(10);

//Category Section
$objPlCategory=new PlCategory();
$showCategory=$objPlCategory->PlShowCategoryOnHome(10);

//Random Stuff Section
$objPlRandomTags=new PlStuff();
$showRandomTags=$objPlRandomTags->PlShowRandomStuffTagsOnHome(10);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="rtl" lang="he" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Home Page</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link href="http://www.freelancer.com/rss.xml" rel="alternate" type="application/rss+xml" title="Latest projects" />

        <!--For Ajax Tool Tip
        <link rel="stylesheet" href="css/ajax-tooltip.css" media="screen" type="text/css"/>
	<link rel="stylesheet" href="css/ajax-tooltip-demo.css" media="screen" type="text/css"/>-->
        <script type="text/javascript" src="js/ajax-dynamic-content.js"></script>
	<script type="text/javascript" src="js/ajax.js"></script>
	<script type="text/javascript" src="js/ajax-tooltip.js"></script>
        <!--Ends here-->
        
        <link href="suggeststuff/css/style.css" rel="stylesheet" type="text/css"/>
        <!--[if gte IE 7]>
            <link rel="stylesheet" type="text/css" href="i_hate_IE.css" />
        <![endif]-->
        <script type="text/javascript" language="JavaScript" src="suggeststuff/js/jquery.js"></script>
        <script type="text/javascript" language="JavaScript" src="suggeststuff/js/script.js"></script>

        <link href="suggestsearch/css/style.css" rel="stylesheet" type="text/css"/>
        <!--[if gte IE 7]>
            <link rel="stylesheet" type="text/css" href="i_hate_IE.css" />
        <![endif]-->
        <script type="text/javascript" language="JavaScript" src="suggestsearch/js/jquery.js"></script>
        <script type="text/javascript" language="JavaScript" src="suggestsearch/js/script.js"></script>

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
                background-image: url(images/logoheader.jpg);
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
                font-weight: bold;
                font-family: Verdana, Arial, Helvetica, sans-serif;
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
            /*Ends here*/
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
                right:110px;
                float: right;
                color: black;
                display: block;
                font-size: 15px;
                font-weight: bold;
                font-family: Verdana, Arial, Helvetica, sans-serif;
                text-align: right;
            }
            #dvMenuContents a
            {
                text-decoration: none;
                color: black;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            #dvMenuContents a:hover
            {
                font-family: Verdana, Arial, Helvetica, sans-serif;
                color: white;
            }
            #dvBrowseStuff
            {
                position: absolute;
                float: left;
                top: 1px;
                display: block;
                left: 10px;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            #dvSearchTextBox
            {
                position: absolute;
                float:left;
                top: 3px;
                left: 240px;
                width: 15%;
                height: 24px;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            .hebrewfonts
            {
                font-family: Verdana, Arial, Helvetica, sans-serif;
                font-size: 12px;
            }

            #dvSearch
            {
                position: absolute;
                float:left;
                top: 1px;
                left: 150px;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            #dvIsBestSection
            {
                width: 978px;
                height: 100px;
                z-index: 4;
                margin-left:auto;
                margin-right:auto;
                padding-top: 10px;
                padding-bottom: 10px;
                display:block; /*Maha Gilinder*/
                padding: 0px;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            #dvIsBest
            {
                display: block;
                width: 430px;
                height: 90px;
                float: right;
                z-index: 4;
                background-image: url(images/IsBestSectionBackground.jpg);
                background-repeat: no-repeat;
                padding: 0px;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            #dvIsBestText
            {
                text-align: right;
                font-family: Verdana, Arial, Helvetica, sans-serif;
                font-size: 18px;
                font-weight: bold;
                color: white;
                padding-right: 20px;
            }
            #dvIsBestTextBox
            {
                float: right;
                padding-right: 10px;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            #dvIsBestButton
            {
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            #dvDoYouAgree
            {
                float: left;
                display: block;
                width: 390px;
                height: 90px;
                z-index: 4;
                background-image: url(images/DoYouThinkBackground.jpg);
                background-repeat: no-repeat;
                padding: 0px;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            #dvDoYouAgreeImage
            {
                position: relative;
                left: 10px;
                top: 0px;
                float: left;
                display: block;
                width: 100px;
                height: 88px;
                z-index: 4;
                background-image: url(images/manthinkimagebackground.jpg);
                background-repeat: no-repeat;
                padding-top: 4px;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            #dvManThinks
            {
                float: right;
                display: block;
                padding-right: 10px;
                padding-top: 2px;
                color:#f9c60b;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            #dvThinkingStuff
            {
                float: right;
                display: block;
                padding-right: 20px;
                padding-top: 3px;
                color:#2296b9;
                font-family: arial;
                font-weight: bold;
                font-size: 14px;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            #spThinks
            {
                color:white;
                font-weight: bold;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            #dvThinkingIsBest
            {
                float: right;
                display: block;
                padding-right: 70px;
                padding-top: 2px;
                color:#f9c60b;
                font-family: Verdana, Arial, Helvetica, sans-serif;
                font-weight: bold;
                font-size: 14px;
            }
            #dvWhatDoYouThink
            {
                float: right;
                display: block;
                padding-right: 90px;
                padding-top: 1px;
                color:white;
                font-family: Verdana, Arial, Helvetica, sans-serif;
                font-weight: bold;
                font-size: 19px;
            }
            #dvYesNo
            {
                position: relative;
                top:-30px;
                left: 3px;
                width: 150px;
                height: 30px;
                float: left;
                display: block;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            #dvCollage
            {
                position: relative;
                /*top:100px;
                left:2px;*/
                /*width: 960px;
                height: 380px;*/
                width:auto;
                height:auto;
                z-index: 2;
                /*background-image: url(images/CollageBackground.jpg);
                background-repeat: no-repeat;*/
               
                border: 3px solid #233645;
                max-width: 910px;
                max-height: 380px;
                display:block; /*Maha Gilinder*/
                font-family: Verdana, Arial, Helvetica, sans-serif;
                text-align: right;
            }
            #imgCollage
            {
                padding-top: 3px;
                width: 950px;
                height: 370px;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }

            #dvCollageImages
            {
                display: block;
                /*margin-left:1px;
                margin-right:1px;
                margin-top: 1px;
                margin-bottom: 1px;
                display: table;
                position: relative;
                height: 32px;
                width: 32px;
                border-style: groove;
                border-width: thin;
                border-color: #1c2e3c;
                right: 8px;
                left:4px;
                top:1px;
                bottom: 1px;
                margin-left:1px;
                margin-right:1px;
                margin-top: 1px;
                margin-bottom: 1px;
                font-family: Verdana, Arial, Helvetica, sans-serif;*/
                padding-top: 2px;
                padding-bottom: 2px;
                padding-left: 0px;
                padding-right: 0px;
            }
            
            #dvCollageImageTable
            {
                position: relative;
                display: table;
                background-color: white;

            }
            /*#dvCollageImageTable img
            {
                border-width: 0px;
                border-style: solid;
                display: table-cell;
                padding: 0 0 0 0;
                border-collapse: collapse;
                vertical-align: top;
                width: auto;
                height: auto;
            }*/
            .collageimagetableborder
            {
                border-style: solid;
                table-layout: auto;
                max-width: 910px;
                max-height: 380px;
                border-collapse: collapse;
                border-spacing: 0;
                padding: 0;
                background-color: #233645;
                border-color: white;
                background-color: #FFFFFF;
                width:890px;
                height:auto;                
                /*max-width: 870px;
                max-height: 380px;*/
            }
            
            /*#dvCollageImageTable td {display: table-cell; overflow: hidden;}
            #dvCollageImageTable td img {height: inherit;width: inherit;}*/
            /*.size1{height:30px;width:30px;}
            .size2{height:30px;width:62;}
            .size3{min-height:62px;width:30px;}
            .size4{height:60px;width:100%;}
            .size5{height:125px;width:130px;}*/
            
            /*li{list-style-type: none;float: right;}*/
            #dvOptions
            {
                width: 978px;
                display: block;
                height: auto;
                padding: 0;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            #dvNewStuffTitle
            {
                color: white;
                background-image: url(images/categorititles.jpg);
                background-repeat: no-repeat;
                width:298px;
                height: 32px;
                display: block;
                float: left;
                padding-top: 5px;
                padding-left: -50px;
                font-weight: bold;
                font-family: Verdana, Arial, Helvetica, sans-serif;
                font-size: 16px;
            }
            #dvNewStuff
            {
                position: relative;
                top: 1px;
                left:45px;
                display: block;
                float: left;
                width: 300px;
                height: auto;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            #dvNewStuffContents
            {
                position: relative;
                top: 1px;
                left:0px;
                display: table;
                float: left;
                width: 300px;
                height: 200px;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            #dvCategoryTitle
            {
                color: white;
                background-image: url(images/categorititles.jpg);
                background-repeat: no-repeat;
                width:298px;
                height: 32px;
                display: block;
                float: left;
                padding-top: 5px;
                padding-left: -50px;
                font-weight: bold;
                font-family: Verdana, Arial, Helvetica, sans-serif;
                font-size: 16px;
            }
            #dvCategory
            {
                position: relative;
                top: 1px;
                left:35px;
                display: block;
                float: left;
                width: 300px;
                height: auto;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            #dvCategoryContents
            {
                position: relative;
                top: 1px;
                left:0px;
                display: table;
                float: left;
                width: 300px;
                height: 200px;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            #dvRandomTitle
            {
                color: white;
                background-image: url(images/categorititles.jpg);
                background-repeat: no-repeat;
                width:298px;
                height: 32px;
                display: block;
                float: left;
                padding-top: 5px;
                padding-left: -50px;
                font-weight: bold;
                font-family: Verdana, Arial, Helvetica, sans-serif;
                font-size: 16px;
            }
            #dvRandom
            {
                position: relative;
                top: 1px;
                left:25px;
                display: block;
                float: left;
                width: 300px;
                height: auto;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            #dvRandomContents
            {
                position: relative;
                top: 1px;
                left:0px;
                display: table;
                float: left;
                width: 300px;
                height: 200px;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            #dvActiveMembers
            {
                position: relative;
                float: right;
                top: 1px;
                right:40px;
                display: block;
                width: 700px;
                height: 120px;
                padding: 1px;
                padding-left: 5px;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            #dvActiveMembersTitle
            {
                position: relative;
                color: white;
                background-image: url(images/activememberstitlecopy.jpg);
                background-repeat: no-repeat;
                width:700px;
                height: 32px;
                display: block;
                margin-left:auto;
                margin-right:auto;
                padding-top: 5px;
                padding-left: -100px;
                font-weight: bold;
                font-size: 14px;
                text-align: right;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            #dvActiveMemberImages
            {
                padding-top: 3px;                
                display: block;
                font-family: Verdana, Arial, Helvetica, sans-serif;
                text-align: right;
            }
            #dvActiveMemberImages img
            {
                border-style: solid;
                border-width: 1px;
                border-color: #1c2e3c;
                padding: 1px;
                margin-left:1px;
                margin-right:1px;
                margin-top: 1px;
                margin-bottom: 2px;
                background-color: #f9c60b;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
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
                float: left;
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
                font-size: 13px;
                color: blue;
                width: 300px;
            }
            .table a
            {
                text-decoration: none;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            .table a:hover
            {
                text-decoration: underline;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
            .odd
            {
                background-color: #fef5ce;
                font-family: Verdana, Arial, Helvetica, sans-serif;
            }
        </style>

        <style type="text/css">

        .borderit img{
        border: 2px solid #ccc;
        }

        .borderit:hover img{
        border: 2px solid #5dafdf;
        }

        .borderit:hover{
        color: red; /* irrelevant definition to overcome IE bug */
        }

        </style>


        <script type="text/javascript" language="JavaScript">
            String.prototype.trim = function()
            {
                return this.replace(/(?:(?:^|\n)\s+|\s+(?:$|\n))/g,"");
            }

            function CategoryValid()
            {
                if(document.frmaddcategory.txtAddCategory.value.trim()=="")
                    return false;
                else
                    return true;
            }            
         </script>
        
        <script type="text/javascript" language="JavaScript">
            var xhr=null;
            function GetXMLHttp()
            {
                try
                {
                    xhr=new ActiveXObject("Microsoft.XMLHTTP");
                }
                catch(e)
                {
                    xhr=new XMLHttpRequest();
                }
                return xhr;
            }

            function BrowserCloseLogout()
            {
                mid=document.getElementById("memberid").value;
                ///url="logoutonbrowserclose.php?memberid="+mid;
                url="mylogout.php";
                alert(url);
                xhr=new GetXMLHttp();
                xhr.onreadystatechange=BrowserStateChange;
                xhr.open('GET',url,true);
                xhr.send(null);
            }
            function BrowserStateChange()
            {
                alert(xhr.readyState);
                if(xhr.readyState==4)
                {
                    window.close();
                }
            }
            var clicked= false;
            function CheckBrowser()
            {                
                /*if (clicked==false)
                {
                    alert(clicked);
                    BrowserCloseLogout();
                }
                else
                {
                    clicked = false;
                }*/
            }
        </script>
        <script type="text/javascript" language="javascript">
            function disableEnterKey(e)
            {
                var key;
                if(window.event)
                    key = window.event.keyCode; //IE
                else
                    key = e.which; //firefox

                return (key != 13);
            }
        </script>
    </head>
    <body>
        <!---<form name="frmaddcategory" method="POST" action="Stuff/AddMyStuff.php" enctype="multipart/form-data" onsubmit="return CategoryValid();">-->
            <div id="dvMain" align="center">
                <div id="dvBanner">
                        
                        <?php
                            if(isset($_SESSION['member']))
                            {
                        ?>
                                <div id="dvLogin">                                    
                                    <a href="logout.php" title="Logout"> logout </a> |
                                    <a href="member/comments.php?profileid=<?php echo $_SESSION['memberid']; ?>&member=<?php echo $_SESSION['member']; ?>" title="Comments"> comments </a>|
                                    <a href="member/stuffs.php?profileid=<?php echo $_SESSION['memberid']; ?>&member=<?php echo $_SESSION['member']; ?>" title="Stuffs"> stuff </a> |
                                    <a href="member/profile.php?profileid=<?php echo $_SESSION['memberid']; ?>&member=<?php echo $_SESSION['member']; ?>" title="Member Profile"><?php echo $_SESSION['member']; ?></a>
                                    <input type="hidden" id="memberid" name="memberid" value="<?php echo $_SESSION['memberid'] ?>"/>
                                    <div style="clear: both;"></div>
                                </div>
                                <div style="position: absolute;float:left;left: 875px;width: 105px;height: 120px;">
                                    <a href="index.php" style="outline: none;">
                                            <img src="images/hotspot.png" border="0" alt=""/>
                                    </a>
                                </div>
                        <?php
                            }
                            else
                            {
                        ?>
                                <div id="dvNotLogin">
                                    <a href="member/login.php" title="Login">התחבר</a> |
                                    <span class="spNotAMember" title="Not a Member">עדיין לא רשום ?</span>
                                    <a href="member/signup.php" title="Sign Up"> הרשם עכשיו </a>
                                </div>
                                <div style="position: absolute;float:left;left: 875px;width: 105px;height: 120px;">
                                    <a href="index.php" style="outline: none;">
                                            <img src="images/hotspot.png" border="0" alt=""/>
                                    </a>
                                </div>
                        <?php
                            }
                        ?>
                        
                    <div style="clear: both;"></div>
                    <div id="dvMenuStrip">
                        <div id='dvMenuContents'>
                            <a href="index.php" title="HOME">ראשי</a> <a href="faq.php" title="FAQ">שאלות נפוצות</a>
                        </div>
                        
                        <form id="frmSearch"  name="frmSearch" method="post" action="Stuff/BrowseSearchStuff.php?page=1&ipp=20">
                            <input class="hebrewfonts" type="text" id="txtsearch" name="txtsearch" size="23" style="position: relative;left:-172px;top:-14px;z-index:4;" size="21" OnKeyPress="return disableEnterKey(event);"/>
                            <div id="dvSearchTextBox">                                
                                <div class="main">
                                    <div id="holder" style="clear: both;">
                                        <!--<input class="hebrewfonts" type="text" id="txtsearch" name="txtsearch" tabindex="0" size="21" OnKeyPress="return disableEnterKey(event);"/>-->
                                        <img src="suggestsearch/images/loading.gif" id="loading" alt=""/>
                                    </div>
                                    <div id="ajax_response_search"></div>
                                </div>
                            </div>
                            <span style='font-size: 1px;'>&nbsp;</span>
                            <div id="dvSearch">
                                <input type="image" value="" id="btnSearch" name="btnSearch" src='images/search.png' width='80px' height='24px' alt='' />
                                <!--<input type="submit" value="Search"/>-->
                            </div>
                        </form>
                        <span style='font-size: 1px;'>&nbsp;</span>
                        <div style="clear: both;"></div>
                        <div id="dvBrowseStuff">
                            <a href="Stuff/BrowseStuff.php?page=1&ipp=20"><img id="btnBrowser" name="btnBrowse" src='images/BrowseStuff.png' width='130px' height='24px' alt='' border="0"/></a>
                        </div>
                    </div>
                </div>
                <span style='font-size: 1px;'>&nbsp;</span>
                <span style='font-size: 1px;'>&nbsp;</span>
                <div id="dvIsBestSection">
                    <div id="dvIsBest">
                        <form id="frmIsBest" name="frmIsBest" method="post" action="Stuff/AddMyStuff.php">
                            <span style='font-size: 1px;'>&nbsp;</span>
                            <div id="dvIsBestText">
                                מה לדעתכם הדבר הכי טוב בעולם ?
                            </div>
                            <div id="dvIsBestTextBox">
                                <!--<input type="text" id="txtisbest" name="txtStuffName" size="40"/>-->
                                <!--Stuff Auto Suggest Feature-->
                                <div class="main">
                                    <div id="holder">
                                        <input style="font-family: Verdana, Arial, Helvetica, sans-serif;" type="text" id="txtStuffname" name="txtStuffname" tabindex="0" size="35" OnKeyPress="return disableEnterKey(event);"/>
                                        <img src="suggeststuff/images/loading.gif" id="loading"/>
                                    </div>
                                    <div id="ajax_response_stuff"></div>
                                </div>
                                <!--Stuff Auto Suggest feature ends here-->
                            </div>                            
                            <div id="dvIsBestButton">
                                <input type="image" value="" id="btnisbest" name="btnisbest" src="images/IsBestButton.jpg"/>
                            </div>                            
                        </form>
                    </div>
                    <?php
                        $whatdoyouthink=$objPlStuff->PlWhatDoYouThinkIsBestOnHome();
                    ?>
                   
                    <div id="dvDoYouAgree">
                        <form name="frmwhatdoyouthink" method="post" action="whatdoyouthink.php">
                        <div id="dvManThinks">
                            <!--<span>Redman </span><span id="spThinks">חושב ש...</span>-->
                            <span><?php echo $whatdoyouthink[0]['Nickname']; ?> </span><span id="spThinks">חושב ש...</span>
                        </div>
                        <div style="clear: both;"></div>
                        <div id="dvThinkingStuff">
                            <!--(תילארשי הקהל) לוחכה ליפה-->
                            <?php echo $whatdoyouthink[0]['StuffTitle']; ?>
                        </div>
                        <div style="clear: both;"></div>
                        <div id="dvThinkingIsBest">
                            <!--היא הלהקה הכי טובה-->
                            <?php echo $whatdoyouthink[0]['CategoryTitle']; ?>
                        </div>
                        <div style="clear: both;"></div>
                        <div id="dvWhatDoYouThink">
                            האם אתה מסכים?
                        </div>
                        <div style="clear: both;"></div>
                        <?php $whatdoyouthinkanswer=$whatdoyouthink[0]['MemberID']."-".$whatdoyouthink[0]['CategoryID']."-".$whatdoyouthink[0]['StuffID'];  ?>
                        <div id="dvYesNo">
                            <input type="image" value="yes" id="btnyes" name="btnyes" src="images/yes.jpg"/>
                            <input type="image" value="no" id="btnno" name="btnno" src="images/no.jpg"/>
                            <input type="hidden" name="whatdoyouthink" value="<?php echo $whatdoyouthinkanswer; ?>"/>
                        </div>
                        </form>
                    </div>
                   
                    <div id="dvDoYouAgreeImage">
                        <img src="member/memberimages/<?php echo $whatdoyouthink[0]['ProfileImagePath']; ?>" width="90px" height="80px"/>
                    </div>
                </div>
                <span style='font-size: 1px;'>&nbsp;</span>
                <span style='font-size: 1px;'>&nbsp;</span>
                <div id="dvCollage">
                    <!--<img id="imgCollage" src="images/collage_jpg.jpg"/>-->
                    <div id="dvCollageImages" align="center">
                        <div id="dvCollageImageTable">
                            <?php
                                if(isset($showCollage))
                                    echo $showCollage;
                            ?>
                        </div>
                    </div>
                </div>
                <div style="clear: both;"></div>
                <span style='font-size: 1px;'>&nbsp;</span>
                <span style='font-size: 1px;'>&nbsp;</span>
                <div id="dvOptions">
                    <div id="dvRandom" align="right">
                        <div id="dvRandomTitle" title="Random">&nbsp;&nbsp;&nbsp;<!---<span>קטגריות חדשות</span>-->
                            <?php echo $_SESSION['randomtag']; ?>
                        </div>
                        <div id="dvRandomContents">
                            <?php
                                if(isset($showRandomTags))
                                    echo $showRandomTags;
                            ?>
                        </div>
                    </div>
                    
                    <div id="dvCategory" align="right">
                        <div id="dvCategoryTitle" title="Categories">&nbsp;&nbsp;&nbsp;נושאים אחרונים</div>
                        <div id="dvCategoryContents">
                            <?php
                                if(isset($showCategory))
                                    echo $showCategory;
                            ?>
                        </div>
                    </div>
                    
                    <div id="dvNewStuff" align="right">
                        <div id="dvNewStuffTitle" title="New Stuff">&nbsp;&nbsp;&nbsp;אחר</div>
                        <div id="dvNewStuffContents">
                            <?php
                                if(isset($showStuffs))
                                    echo $showStuffs;
                            ?>
                        </div>
                    </div>
                    <div style="clear: both;"></div>
                </div>
                <span style='font-size: 1px;'>&nbsp;</span>
                <span style='font-size: 1px;'>&nbsp;</span>
                <br></br>
                <br></br>
                <div id="dvActiveMembers" align="right">
                    <div id="dvActiveMembersTitle" title="Active Members" align="right">
                        &nbsp;&nbsp;&nbsp;חברים פעילים
                    </div>
                    <div id="dvActiveMemberImages">
                        <?php
                            $objBoActiveMembers=new BoMemberRegistration();
                            $objBoActiveMembers->setOnlineStatus('O');

                            $objPlActiveMembers=new PlMemberRegistration();
                            $output=$objPlActiveMembers->PlShowActiveMembersListOnHomePage($objBoActiveMembers);
                            echo $output;
                        ?>
                    </div>
                </div>               
                <div id="dvFacebookLikeBox" style="float:right;right:50px;position: relative;">
                    <iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Ftopic.php%3Fuid%3D119907861372773%26topic%3D75%23%21%2Fpages%2FMacrosoft-Solutions%2F119907861372773&amp;width=200&amp;colorscheme=light&amp;connections=6&amp;stream=false&amp;header=true&amp;height=287" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:200px; height:287px;" allowTransparency="true"></iframe>
                </div>
                <div style="clear:both;"/>               
            </div>
        <!--Main Div ends -->
        
        <span style='font-size: 1px;'>&nbsp;</span>        
        <div id='dvFooter' align="center">            
            <a href="#">home |</a> <a href="#">faq |</a>
            <a href="#">privacy policy |</a> <a href="#">term and conditions |</a>
            <a href="#">contact us |</a> <a href="#">rss feed |</a> <a href="#">bookmark this page</a><br/>
            Copyright &copy;2010 Avigabso. Designed & Developed by <a href="http://themacrosoft.com">Macrosoft Solutions</a>
        </div>
    </body>
</html>