-- MySQL dump 10.13  Distrib 8.0.32, for Win64 (x86_64)
--
-- Host: localhost    Database: user_management_techbridge
-- ------------------------------------------------------
-- Server version	5.7.36

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `blogs_categories`
--

DROP TABLE IF EXISTS `blogs_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `blogs_categories` (
  `blogs_categories_id` int(11) NOT NULL AUTO_INCREMENT,
  `categories_name` varchar(225) NOT NULL,
  `categories_description` text NOT NULL,
  `categories_keywords` varchar(225) NOT NULL,
  `user_type_at_creation_time` varchar(225) NOT NULL DEFAULT 'Admin',
  `created_by` int(11) NOT NULL,
  `edited_by` int(11) DEFAULT NULL,
  `categories_status` varchar(11) NOT NULL DEFAULT 'Inactive',
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `added_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`blogs_categories_id`),
  KEY `created_by` (`created_by`),
  KEY `edited_by` (`edited_by`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blogs_categories`
--

LOCK TABLES `blogs_categories` WRITE;
/*!40000 ALTER TABLE `blogs_categories` DISABLE KEYS */;
INSERT INTO `blogs_categories` VALUES (1,'Nautral Lifestyle','Natural living means living in harmony with the earth and making conscious choices to use natural, toxic-free and organic products. ItΓÇÖs about living connected to nature and following the earthΓÇÖs natural rhythms to truly feel connected to life, improve your health and live sustainably.','natural, lifestyle','Admin',1,1,'Active','2023-07-11 22:49:58','2023-07-02 15:53:50'),(2,'Creative & Unique','Unique words are those that are not used too often. They can also be words that describe ΓÇÿuniqueΓÇÖ characteristics and personalities, which we donΓÇÖt tend to see in others very often.  Sometimes, people may refer to someone as ΓÇÿuniqueΓÇÿ as in a different or one of a kind type of individual. Whilst they may mean this as ΓÇÿuniqueΓÇÖ in a positive way, or may be avoiding saying describing words such as abnormal, strange or odd. ItΓÇÖs all a matter of context.  If youΓÇÖre looking for something a little different to describe someone, then this list of positive, unique adjectives will come in very handy. ','creative, unique','Admin',1,1,'Active','2023-07-11 22:50:04','2023-07-02 15:58:37'),(10,'Responsive Templates2','Truth is, I didnΓÇÖt understand page layout design or how to put together a webpage that conveyed my intended message and was visually appealing to my audience. I spent a lot of time testing new designs and tinkering with my webpage until I found the exact look and feel I was going for.  If youΓÇÖre feeling like I was ΓÇö a little intimidated by website design ΓÇö you donΓÇÖt have to go through the same struggles that I did.  In this post, weΓÇÖll cover some of the basics of page layout design then provide a list of design ideas and concepts that can serve as inspiration for your own website.','natural, lifestyle','Admin',1,9,'Active','2023-07-18 01:31:55','2023-07-18 01:18:50');
/*!40000 ALTER TABLE `blogs_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blogs_details`
--

DROP TABLE IF EXISTS `blogs_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `blogs_details` (
  `blog_id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_title` varchar(225) NOT NULL,
  `blog_short_description` varchar(225) NOT NULL,
  `blog_content` text NOT NULL,
  `blog_keywords` varchar(225) NOT NULL,
  `blogs_categories_id` int(11) NOT NULL,
  `blog_status` varchar(64) NOT NULL DEFAULT 'Inactive',
  `created_by` int(11) NOT NULL,
  `edited_by` int(11) DEFAULT NULL,
  `user_type_at_creation_time` varchar(64) NOT NULL COMMENT 'Which User Type adding Blog',
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `added_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`blog_id`),
  KEY `blogs_categories_id` (`blogs_categories_id`),
  KEY `created_by` (`created_by`),
  KEY `edited_by` (`edited_by`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blogs_details`
--

LOCK TABLES `blogs_details` WRITE;
/*!40000 ALTER TABLE `blogs_details` DISABLE KEYS */;
INSERT INTO `blogs_details` VALUES (8,'Aenean Pulvinar Gravida Sem Nec','<p>njnj</p>','<p>hhhu</p>','resume, video, multipage, ok',2,'Active',1,1,'Admin','2023-07-18 01:18:20','2023-07-11 00:09:28'),(10,'Focus visible by default','<p>as</p>','<p>sd</p>','CSS, addition, html5',1,'Active',1,1,'Admin','2023-07-18 01:18:22','2023-07-18 01:18:17'),(11,'CSS Reset Additions','<p>nhn</p>','<p>nhnh</p>','CSS, addition, html5',10,'Active',1,9,'Admin','2023-07-18 01:31:39','2023-07-18 01:18:37');
/*!40000 ALTER TABLE `blogs_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blogs_to_categories`
--

DROP TABLE IF EXISTS `blogs_to_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `blogs_to_categories` (
  `blogs_to_categories_id` int(11) NOT NULL AUTO_INCREMENT,
  `categories_id` int(11) NOT NULL,
  `blogs_id` int(11) NOT NULL,
  PRIMARY KEY (`blogs_to_categories_id`),
  KEY `categories_id` (`categories_id`),
  KEY `blogs_id` (`blogs_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blogs_to_categories`
--

LOCK TABLES `blogs_to_categories` WRITE;
/*!40000 ALTER TABLE `blogs_to_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `blogs_to_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles_activities_details`
--

DROP TABLE IF EXISTS `roles_activities_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles_activities_details` (
  `roles_activities_id` int(11) NOT NULL AUTO_INCREMENT,
  `activities_name` varchar(225) NOT NULL,
  `activities_description` text NOT NULL,
  `activities_keywords` varchar(225) NOT NULL COMMENT 'These keywords refers to a particular methods to perform any activities, it will use to give permission to the user.\r\n',
  `redirection_url` varchar(1000) NOT NULL DEFAULT 'admin/dashboard' COMMENT 'When Activities not allowed to user, it will use for redirection of user.',
  `message_to_user` varchar(1000) NOT NULL DEFAULT 'Permission Denied, Please contact to Administration' COMMENT 'When not allowed to the users.',
  `user_type_at_creation_time` varchar(225) NOT NULL,
  `created_by` int(10) NOT NULL,
  `edited_by` int(10) DEFAULT NULL,
  `activities_status` varchar(225) NOT NULL DEFAULT 'Inactive',
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `added_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`roles_activities_id`),
  UNIQUE KEY `activities_keywords` (`activities_keywords`),
  KEY `created_by` (`created_by`),
  KEY `edited_by` (`edited_by`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles_activities_details`
--

LOCK TABLES `roles_activities_details` WRITE;
/*!40000 ALTER TABLE `roles_activities_details` DISABLE KEYS */;
INSERT INTO `roles_activities_details` VALUES (1,'Add Roles Activities','Users can add any new roles activities.','addRoleActivities','admin/roleActivities','Permission Denied, Please contact to Administration','Admin',1,1,'Active','2023-07-13 21:17:13','2023-07-04 23:59:56'),(3,'Edit Roles Activities ','Users can edit any roles activities','editRoleActivities','admin/roleActivities','Permission Denied, Please contact to Administration','Admin',1,1,'Active','2023-07-12 00:05:38','2023-07-05 21:58:07'),(4,'Change Role\'s Activities Status','Users can change any role\'s aactivities status.','enabledDisabledRoleActivities','admin/roleActivities','Permission Denied, Please contact to Administration','Admin',1,1,'Active','2023-07-12 00:05:38','2023-07-05 22:01:17'),(5,'deleteRoleActivities','Users can delete any roles activities','deleteRoleActivities','admin/roleActivities','Permission Denied, Please contact to Administration','Admin',1,1,'Active','2023-07-12 00:05:38','2023-07-05 22:02:09'),(6,'Add Users','Users can add new users.','addUser','admin/users','Permission Denied, Please contact to Administration','Admin',1,1,'Active','2023-07-12 00:05:38','2023-07-05 22:56:22'),(7,'Edit Users','Users can edit any user.','editUser','admin/users','Permission Denied, Please contact to Administration','Admin',1,1,'Active','2023-07-12 00:05:38','2023-07-05 22:56:55'),(21,'Delete Role','User can delete any role','deleteRole','admin/roles','Permission Denied, Please contact to Administration','Admin',1,5,'Active','2023-07-13 01:10:27','2023-07-09 16:16:20'),(8,'Change User\'s Status','Users can change any user\'s status.','enabledDisabledUser','admin/users','Permission Denied, Please contact to Administration','Admin',1,1,'Active','2023-07-12 00:05:38','2023-07-05 22:57:24'),(9,'Delete User','Users can delete any User.','deleteUser','admin/users','Permission Denied, Please contact to Administration','Admin',2,1,'Active','2023-07-12 00:05:38','2023-07-05 22:58:24'),(24,'Add Blog','Users can add any new blogs','addBlog','admin/blogs','Permission Denied, Please contact to Administration','Admin',1,1,'Active','2023-07-18 01:19:41','2023-07-11 23:07:10'),(27,'See All Assigned Activities List','Users can see all the assigned activities to any role.','seeAllAssignedActivitiesList','admin/roles','Permission Denied, Please contact to Administration','Admin',1,1,'Active','2023-07-13 00:02:21','2023-07-13 00:01:59'),(11,'Edit Blogs','Users can change any category\'s status.','editBlog','admin/blogs','Permission Denied, Please contact to Administration','Admin',2,1,'Active','2023-07-11 23:39:20','2023-07-05 23:01:46'),(12,'Change Blog\'s Status','Users can change any blog\'s status.','enabledDisabledBlog','admin/blogs','Permission Denied, Please contact to Administration','Admin',2,1,'Active','2023-07-11 23:39:20','2023-07-05 23:02:47'),(13,'Delete Blog','Users can delete any blog.','deleteBlog','admin/blogs','Permission Denied, Please contact to Administration','Admin',2,1,'Active','2023-07-11 23:39:20','2023-07-05 23:10:10'),(19,'Edit Roles','Users can edit this role','editRole','admin/roles','Permission Denied, Please contact to Administration','Admin',1,1,'Active','2023-07-11 23:39:20','2023-07-09 16:13:50'),(14,'Add Blog\'s Categories','Users can add new Categories.','addCategories','admin/blogscategories','Permission Denied, Please contact to Administration','Admin',2,1,'Active','2023-07-11 23:39:20','2023-07-05 23:12:10'),(15,'Edit Blog\'s Categories','Users can edit any blog\'s Categories.','editCategories','admin/blogscategories','Permission Denied, Please contact to Administration','Admin',2,1,'Active','2023-07-11 23:39:20','2023-07-05 23:12:37'),(16,'Change Blog\'s Categories Status','Users can change any blog\'s categories status.','enabledDisabledCategories','admin/blogscategories','Permission Denied, Please contact to Administration','Admin',2,1,'Active','2023-07-11 23:39:20','2023-07-05 23:13:06'),(17,'Delete Categories','Users can delete any Categories.','deleteCategories','admin/blogscategories','Permission Denied, Please contact to Administration','Admin',2,1,'Active','2023-07-11 23:39:20','2023-07-05 23:13:29'),(18,'Add Roles','Users can add new roles','addRole','admin/roles','Permission Denied, Please contact to Administration','Admin',1,1,'Active','2023-07-11 23:39:20','2023-07-09 16:12:19'),(20,'Change Role\'s Status','Users can change any role\'s status','enabledDisabledRole','admin/roles','Permission Denied, Please contact to Administration','Admin',1,1,'Active','2023-07-11 23:39:20','2023-07-09 16:15:55'),(26,'Assign Roles Activities','Users can assign any new roles activities.','assignRoleActivities','admin/roles','Permission Denied, Please contact to Administration','Admin',1,1,'Active','2023-07-12 00:05:48','2023-07-11 23:42:55'),(25,'Assign Roles','Users can assign roles to any users.','assignRoles','admin/users','Permission Denied, Please contact to Administration','Admin',1,1,'Active','2023-07-12 00:05:48','2023-07-11 23:41:44'),(28,'User List','Users can see all details of users.','userList','admin/dashboard','Permission Denied, Please contact to Administration','Admin',1,1,'Active','2023-07-17 21:07:26','2023-07-17 20:59:49'),(29,'Blogs List','Users can see all blogs ','blogList','admin/dashboard','Permission Denied, Please contact to Administration','Admin',1,1,'Active','2023-07-17 21:07:26','2023-07-17 21:02:36'),(30,'Blogs Categories List','Users can see the blogs categories list','categoriesList','admin/dashboard','Permission Denied, Please contact to Administration','Admin',1,1,'Active','2023-07-17 21:07:26','2023-07-17 21:04:36'),(31,'Role List','Users can see role list','roleList','admin/dashboard','Permission Denied, Please contact to Administration','Admin',1,1,'Active','2023-07-17 21:07:26','2023-07-17 21:05:05'),(32,'Role Activities List','Users can see the Role activities list','roleActivitiesList','admin/dashboard','Permission Denied, Please contact to Administration','Admin',1,1,'Active','2023-07-17 21:07:26','2023-07-17 21:06:14'),(33,'Bulk User Status Changed','Users can change the status of any user in bulk','bulkUsersStatusChanged','admin/users','Permission Denied, Please contact to Administration','Admin',1,1,'Active','2023-07-18 19:50:09','2023-07-18 19:26:55'),(34,'Bulk Blogs Status Changed','Users can change any blog\'s status in bulk.','bulkBlogsStatusChanged','admin/blogs','Permission Denied, Please contact to Administration','Admin',1,1,'Active','2023-07-18 19:50:09','2023-07-18 19:39:37'),(35,'Bulk Categories Status Changed','Users can change any blog\'s status in bulk.\r\n','bulkCategoriesStatusChanged','admin/blogsCategories','Permission Denied, Please contact to Administration','Admin',1,1,'Active','2023-07-18 19:50:09','2023-07-18 19:44:22'),(36,'Bulk Roles Status Changed','Users can change any Role\'s status in bulk.\r\n','bulkRolesStatusChanged','admin/roles','Permission Denied, Please contact to Administration','Admin',1,1,'Active','2023-07-18 19:50:09','2023-07-18 19:47:38'),(37,'Bulk Activities Status Changed','Users can change any Activity status in bulk.\r\n','bulkActivitiesStatusChanged','admin/roleActivities','Permission Denied, Please contact to Administration','Admin',1,1,'Active','2023-07-18 19:49:59','2023-07-18 19:49:40'),(38,'Bulk User Delete','Users can delete any users in bulk.','deleteBulkUsers','admin/users','Permission Denied, Please contact to Administration','Admin',1,1,'Active','2023-07-18 19:56:26','2023-07-18 19:51:44'),(39,'Bulk Delete Blogs','Users can delete any blogs in bulk.','deleteBulkBlogs','admin/blogs','Permission Denied, Please contact to Administration','Admin',1,1,'Active','2023-07-18 19:56:26','2023-07-18 19:52:23'),(40,'Bulk Delete Blogs Categories','Users can delete any blog\'s Categories in bulk.','deleteBulkCategories','admin/blogsCategories','Permission Denied, Please contact to Administration','Admin',1,1,'Active','2023-07-18 19:56:26','2023-07-18 19:53:11'),(41,'Bulk Delete Roles','Users can delete any roles in bulk.','deleteBulkRoles','admin/roles','Permission Denied, Please contact to Administration','Admin',1,1,'Active','2023-07-18 19:56:26','2023-07-18 19:54:01'),(42,'Bulk Delete Roles Activities','Users can change any role\'s activities in bulk.\r\n','deleteBulkActivities','admin/roleActivities','Permission Denied, Please contact to Administration','Admin',1,1,'Active','2023-07-18 19:56:26','2023-07-18 19:56:12'),(43,'Filter Out Users','Users can use filters and filter out data by keywords, user type, and role name. ','filterOutUser','admin/users','Permission Denied, Please contact to Administration','Admin',1,1,'Active','2023-07-18 20:00:47','2023-07-18 20:00:17'),(44,'Export Users List','Users can export or download the users list in xlsx format.','exportUsers','admin/users','Permission Denied, Please contact to Administration','Admin',1,1,'Active','2023-07-19 00:21:18','2023-07-19 00:16:16'),(45,'Export Blogs List','Users can export or download the blogs list in xlsx format.','exportBlogs','admin/blogs','Permission Denied, Please contact to Administration','Admin',1,1,'Active','2023-07-19 00:21:18','2023-07-19 00:17:10'),(46,'Export Blogs Categories List','Users can export or download the blog\'s categories list in xlsx format.','exportCategories','admin/blogsCategories','Permission Denied, Please contact to Administration','Admin',1,1,'Active','2023-07-19 00:21:18','2023-07-19 00:17:56'),(47,'Export Roles List','Users can export or download the roles list in xlsx format.','exportRoles','admin/roles','Permission Denied, Please contact to Administration','Admin',1,1,'Active','2023-07-19 00:21:18','2023-07-19 00:18:38'),(48,'Export Roles Activities List','Users can export or download the role\'s activities list in xlsx format.','exportActivities','admin/roleActivities','Permission Denied, Please contact to Administration','Admin',1,1,'Active','2023-07-19 00:21:18','2023-07-19 00:19:45');
/*!40000 ALTER TABLE `roles_activities_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles_details`
--

DROP TABLE IF EXISTS `roles_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles_details` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(225) NOT NULL,
  `role_description` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `edited_by` int(10) DEFAULT NULL,
  `user_type` varchar(225) NOT NULL DEFAULT 'Admin',
  `role_status` varchar(225) NOT NULL DEFAULT 'Inactive',
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `added_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`role_id`),
  UNIQUE KEY `role_name` (`role_name`),
  KEY `created_by` (`created_by`),
  KEY `edited_by` (`edited_by`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles_details`
--

LOCK TABLES `roles_details` WRITE;
/*!40000 ALTER TABLE `roles_details` DISABLE KEYS */;
INSERT INTO `roles_details` VALUES (1,'Admin','Admin has all rights to add/change/delete anything within the organization.',1,1,'Admin','Active','2023-07-19 02:10:30','2023-07-03 22:56:25'),(2,'Junior Admin','Junior Admin can change anything except add or delete any users, roles, and roles activities.',1,1,'Admin','Active','2023-07-18 00:29:52','2023-07-04 21:00:24'),(3,'Associate Junior Admin','Associate Junior Admin can change anything except add, edit, and delete users, roles, and roles activities.\r\n',1,1,'Admin','Active','2023-07-18 00:30:11','2023-07-04 21:01:27'),(7,'Senior Blog Editor','Senior Blog Editor can add, edit, delete, and change the status of any blog, and category. (All rights of blogs)\r\n',1,1,'Admin','Active','2023-07-18 00:20:48','2023-07-18 00:09:49'),(4,'Junior Blog Editor ','Junior Editor can edit and change the status of any Blog and categories.',1,1,'Admin','Active','2023-07-18 00:23:54','2023-07-17 21:21:49'),(5,'Associate Junior Blog Editor','Associate Junior Editor can only change the status of any Blog and categories.',1,1,'Admin','Active','2023-07-18 19:17:15','2023-07-17 21:28:26'),(9,'Viewer','Viewers can only see the information of any user list, blog list, categories list, roles list, and role activities list.\r\n',1,1,'Admin','Active','2023-07-18 01:08:08','2023-07-18 01:02:11');
/*!40000 ALTER TABLE `roles_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles_to_activities`
--

DROP TABLE IF EXISTS `roles_to_activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles_to_activities` (
  `roles_to_activities_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `roles_activities_id` int(11) NOT NULL,
  PRIMARY KEY (`roles_to_activities_id`),
  KEY `role_id` (`role_id`),
  KEY `roles_activities_id` (`roles_activities_id`)
) ENGINE=MyISAM AUTO_INCREMENT=222 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles_to_activities`
--

LOCK TABLES `roles_to_activities` WRITE;
/*!40000 ALTER TABLE `roles_to_activities` DISABLE KEYS */;
INSERT INTO `roles_to_activities` VALUES (30,2,4),(2,2,7),(178,2,1),(177,2,18),(5,1,1),(6,1,3),(7,1,4),(8,1,5),(9,1,6),(38,1,19),(11,1,21),(12,1,8),(13,1,9),(35,2,8),(15,1,11),(16,1,12),(17,1,13),(33,1,7),(19,1,14),(20,1,15),(21,1,16),(95,1,28),(23,1,18),(24,1,20),(25,1,22),(26,1,23),(113,3,12),(28,4,12),(29,4,16),(204,3,19),(146,2,17),(46,2,3),(39,1,24),(43,1,25),(42,1,26),(145,2,13),(98,2,14),(97,2,24),(96,2,28),(94,1,32),(93,1,31),(92,1,30),(91,1,29),(90,1,27),(89,2,30),(88,2,29),(112,4,29),(111,4,30),(85,2,19),(84,2,11),(83,2,15),(82,2,20),(81,2,12),(80,2,16),(104,2,32),(105,2,31),(106,2,27),(107,3,30),(108,3,29),(109,3,15),(110,3,11),(114,3,16),(149,3,4),(203,3,33),(117,7,30),(118,7,29),(119,7,16),(120,7,12),(144,5,12),(143,5,16),(142,5,29),(124,7,15),(125,7,11),(141,5,30),(140,4,11),(139,4,15),(138,7,17),(137,7,13),(136,7,14),(135,7,24),(202,3,36),(201,3,35),(150,3,20),(151,3,8),(200,3,34),(199,3,37),(154,3,32),(155,3,31),(156,3,27),(157,3,28),(169,8,28),(168,8,27),(167,8,31),(166,8,32),(165,8,29),(164,8,30),(179,2,6),(180,2,37),(181,2,34),(182,2,35),(183,2,39),(184,2,40),(185,2,41),(186,2,42),(187,2,36),(188,2,38),(189,2,33),(190,2,21),(191,2,9),(192,2,5),(193,2,46),(194,2,45),(195,2,48),(196,2,47),(197,2,44),(198,2,43),(205,3,3),(206,3,7),(207,3,46),(208,3,45),(209,3,48),(210,3,47),(211,3,44),(212,3,43),(213,7,34),(214,7,35),(215,7,39),(216,7,40),(217,7,46),(218,7,45),(219,5,46),(220,5,45);
/*!40000 ALTER TABLE `roles_to_activities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_details`
--

DROP TABLE IF EXISTS `user_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_details` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(225) NOT NULL,
  `middle_name` varchar(225) NOT NULL,
  `last_name` varchar(225) NOT NULL,
  `email` varchar(225) NOT NULL,
  `user_name` varchar(225) NOT NULL,
  `password` varchar(225) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `user_type` varchar(64) DEFAULT NULL,
  `user_status` varchar(225) NOT NULL DEFAULT 'Inactive',
  `user_type_at_creation_time` varchar(225) NOT NULL DEFAULT 'UserItself' COMMENT 'this user added by ?',
  `created_by` int(11) DEFAULT NULL,
  `edited_by` int(11) DEFAULT NULL,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `added_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  KEY `created_by` (`created_by`),
  KEY `edited_by` (`edited_by`),
  KEY `role_id` (`role_id`),
  KEY `user_type` (`user_type`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_details`
--

LOCK TABLES `user_details` WRITE;
/*!40000 ALTER TABLE `user_details` DISABLE KEYS */;
INSERT INTO `user_details` VALUES (1,'Abhishek','Kumar','Shrivastav','abhi786.2015@gmail.com','abhi67','b5ef261a75dce04c2b86ad4a0d3ea510',1,'Admin','Active','UserItself',1,5,'2023-07-07 23:57:45','2023-07-07 23:57:45'),(5,'Ankit ','Kumar','Kushwaha','ankit123@gmail.com','ankit123','b5ef261a75dce04c2b86ad4a0d3ea510',2,'Junior Admin','Active','Admin',1,1,'2023-07-18 01:15:04','2023-07-09 23:36:35'),(7,'Aakash','Kumar','Mishra','aakash@gmail.com','aakash_mishra123','b5ef261a75dce04c2b86ad4a0d3ea510',3,'Associate Junior Admin','Active','Admin',1,1,'2023-07-18 01:15:12','2023-07-13 01:01:24'),(8,'Sanjay','kumar','Gupta','sanjay@gmail.com','sanjay123','b5ef261a75dce04c2b86ad4a0d3ea510',7,'Senior Blog Editor','Active','Admin',1,5,'2023-07-18 01:15:19','2023-07-13 01:02:16'),(9,'Rohit','Kumar','Shrivastav','rohit@gmail.com','rohit123','b5ef261a75dce04c2b86ad4a0d3ea510',4,'Junior Blog Editor ','Active','Admin',1,1,'2023-07-18 01:15:27','2023-07-18 00:57:42'),(10,'Sakshi','ok','Kumari','sakshi123@gmail.com','sakshi123','b5ef261a75dce04c2b86ad4a0d3ea510',5,'Associate Junior Blog Editor','Inactive','Admin',1,5,'2023-07-19 01:13:27','2023-07-18 01:16:15'),(11,'Rahul','kumar','Yadav','rahul@gmail.com','rahul123','b5ef261a75dce04c2b86ad4a0d3ea510',9,'Viewer','Active','Admin',1,1,'2023-07-18 20:15:41','2023-07-18 01:17:03'),(12,'Amarendra','kumar1','mishra','amrendra@gmail.com','amd123','b5ef261a75dce04c2b86ad4a0d3ea510',9,'Viewer','Inactive','Admin',1,1,'2023-07-18 20:58:53','2023-07-18 20:58:03');
/*!40000 ALTER TABLE `user_details` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-08-02 19:53:20
