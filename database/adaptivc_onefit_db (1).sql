-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2026 at 12:30 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `adaptivc_onefit_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `community_posts`
--

CREATE TABLE `community_posts` (
  `post_id` int(11) NOT NULL,
  `post_date` datetime NOT NULL,
  `post_message` longtext NOT NULL,
  `username` varchar(20) NOT NULL,
  `modified_date` datetime NOT NULL DEFAULT current_timestamp(),
  `favourite_ref` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `community_resources`
--

CREATE TABLE `community_resources` (
  `comm_resource_id` int(11) NOT NULL,
  `resource_title` varchar(50) NOT NULL,
  `resource_description` text DEFAULT NULL,
  `resource_type` varchar(50) NOT NULL,
  `resource_link` text NOT NULL,
  `shared_by` varchar(20) NOT NULL,
  `share_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fave_saves`
--

CREATE TABLE `fave_saves` (
  `fave_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `fave_ref` varchar(50) NOT NULL,
  `fave_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fitblog_comment_comments`
--

CREATE TABLE `fitblog_comment_comments` (
  `comment_id` int(11) NOT NULL,
  `post_comment_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `comment_date` datetime NOT NULL,
  `username` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fitblog_posts`
--

CREATE TABLE `fitblog_posts` (
  `post_id` int(11) NOT NULL,
  `post_date` datetime NOT NULL,
  `post_content` longtext NOT NULL,
  `username` varchar(20) NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `modified_date` datetime NOT NULL DEFAULT current_timestamp(),
  `fave_ref` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fitblog_post_comments`
--

CREATE TABLE `fitblog_post_comments` (
  `post_comment_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `comment_date` datetime NOT NULL,
  `username` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `friend_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `friend_username` varchar(20) NOT NULL,
  `accept_date` datetime NOT NULL,
  `unfriend_date` datetime DEFAULT NULL,
  `friendship_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `group_id` int(11) NOT NULL,
  `group_ref_code` varchar(50) NOT NULL,
  `group_name` varchar(50) NOT NULL,
  `group_description` text NOT NULL,
  `group_category` varchar(20) NOT NULL,
  `group_privacy` varchar(10) NOT NULL,
  `created_by` varchar(20) NOT NULL,
  `creation_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_members`
--

CREATE TABLE `group_members` (
  `group_mem_id` int(11) NOT NULL,
  `group_ref_code` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `group_role` varchar(20) NOT NULL,
  `group_join_date` datetime NOT NULL,
  `active` tinyint(1) NOT NULL,
  `status` tinytext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `interests`
--

CREATE TABLE `interests` (
  `interest_id` int(11) NOT NULL,
  `interest_title` varchar(50) NOT NULL,
  `interest_description` text NOT NULL,
  `created_by` varchar(20) NOT NULL,
  `creation_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `article_id` int(11) NOT NULL,
  `article_title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `creation_date` datetime NOT NULL,
  `created_by` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `notification_title` varchar(50) NOT NULL,
  `notification_message` text NOT NULL,
  `notification_date` datetime NOT NULL,
  `notification_read` tinyint(1) DEFAULT NULL,
  `notify_user` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password_hash` varchar(20) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_surname` varchar(50) NOT NULL,
  `id_number` varchar(20) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `date_of_birth` date NOT NULL DEFAULT '1900-01-01',
  `user_gender` varchar(10) NOT NULL,
  `user_race` varchar(20) DEFAULT NULL,
  `user_nationality` varchar(50) NOT NULL,
  `account_active` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_conversations`
--

CREATE TABLE `user_conversations` (
  `conversation_id` int(11) NOT NULL,
  `conversation_start_date` datetime NOT NULL,
  `primary_user` varchar(20) NOT NULL,
  `secondary_user` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_conversation_messages`
--

CREATE TABLE `user_conversation_messages` (
  `message_id` int(11) NOT NULL,
  `message` longtext NOT NULL,
  `send_date` datetime NOT NULL,
  `message_read` tinyint(1) DEFAULT NULL,
  `message_deleted` tinyint(1) DEFAULT NULL,
  `sender` varchar(20) NOT NULL,
  `receiver` varchar(20) NOT NULL,
  `conversation_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `user_profile_id` int(11) NOT NULL,
  `about` varchar(45) DEFAULT NULL,
  `profile_type` varchar(45) DEFAULT NULL,
  `profile_url` varchar(45) DEFAULT NULL,
  `verification` varchar(50) DEFAULT NULL,
  `profile_banner_url` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_socials`
--

CREATE TABLE `user_socials` (
  `user_social_id` int(11) NOT NULL,
  `social_network` varchar(50) NOT NULL,
  `handle` varchar(50) NOT NULL,
  `link` text NOT NULL,
  `username` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `community_posts`
--
ALTER TABLE `community_posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `username` (`username`),
  ADD KEY `favourite_ref` (`favourite_ref`);

--
-- Indexes for table `community_resources`
--
ALTER TABLE `community_resources`
  ADD PRIMARY KEY (`comm_resource_id`),
  ADD KEY `shared_by` (`shared_by`);

--
-- Indexes for table `fave_saves`
--
ALTER TABLE `fave_saves`
  ADD PRIMARY KEY (`fave_id`),
  ADD KEY `username` (`username`),
  ADD KEY `fave_ref` (`fave_ref`);

--
-- Indexes for table `fitblog_comment_comments`
--
ALTER TABLE `fitblog_comment_comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `username` (`username`),
  ADD KEY `post_comment_id` (`post_comment_id`);

--
-- Indexes for table `fitblog_posts`
--
ALTER TABLE `fitblog_posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `fave_ref` (`fave_ref`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `fitblog_post_comments`
--
ALTER TABLE `fitblog_post_comments`
  ADD PRIMARY KEY (`post_comment_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`friend_id`),
  ADD KEY `username` (`username`,`friend_username`),
  ADD KEY `friend_username` (`friend_username`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`group_ref_code`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `group_members`
--
ALTER TABLE `group_members`
  ADD PRIMARY KEY (`group_mem_id`),
  ADD KEY `group_ref_code` (`group_ref_code`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `interests`
--
ALTER TABLE `interests`
  ADD PRIMARY KEY (`interest_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`article_id`),
  ADD KEY `fk_news_users1_idx` (`created_by`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `fk_notifications_users1_idx` (`notify_user`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_conversations`
--
ALTER TABLE `user_conversations`
  ADD PRIMARY KEY (`conversation_id`),
  ADD KEY `fk_user_conversations_users1_idx` (`primary_user`),
  ADD KEY `fk_user_conversations_users2_idx` (`secondary_user`);

--
-- Indexes for table `user_conversation_messages`
--
ALTER TABLE `user_conversation_messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `fk_user_conversation_messages_users1_idx` (`sender`),
  ADD KEY `fk_user_conversation_messages_users2_idx` (`receiver`),
  ADD KEY `fk_user_conversation_messages_user_conversations1_idx` (`conversation_id`);

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`user_profile_id`);

--
-- Indexes for table `user_socials`
--
ALTER TABLE `user_socials`
  ADD PRIMARY KEY (`user_social_id`),
  ADD KEY `fk_user_socials_users1_idx` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `community_posts`
--
ALTER TABLE `community_posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `community_resources`
--
ALTER TABLE `community_resources`
  MODIFY `comm_resource_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fave_saves`
--
ALTER TABLE `fave_saves`
  MODIFY `fave_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `fitblog_comment_comments`
--
ALTER TABLE `fitblog_comment_comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fitblog_posts`
--
ALTER TABLE `fitblog_posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fitblog_post_comments`
--
ALTER TABLE `fitblog_post_comments`
  MODIFY `post_comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `friend_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `group_members`
--
ALTER TABLE `group_members`
  MODIFY `group_mem_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `interests`
--
ALTER TABLE `interests`
  MODIFY `interest_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `article_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_conversations`
--
ALTER TABLE `user_conversations`
  MODIFY `conversation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_conversation_messages`
--
ALTER TABLE `user_conversation_messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `user_profile_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_socials`
--
ALTER TABLE `user_socials`
  MODIFY `user_social_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `community_posts`
--
ALTER TABLE `community_posts`
  ADD CONSTRAINT `community_posts_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`);

--
-- Constraints for table `community_resources`
--
ALTER TABLE `community_resources`
  ADD CONSTRAINT `community_resources_ibfk_1` FOREIGN KEY (`shared_by`) REFERENCES `users` (`username`);

--
-- Constraints for table `fave_saves`
--
ALTER TABLE `fave_saves`
  ADD CONSTRAINT `fave_saves_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`);

--
-- Constraints for table `fitblog_comment_comments`
--
ALTER TABLE `fitblog_comment_comments`
  ADD CONSTRAINT `fitblog_comment_comments_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `fitblog_comment_comments_ibfk_2` FOREIGN KEY (`post_comment_id`) REFERENCES `fitblog_post_comments` (`post_comment_id`);

--
-- Constraints for table `fitblog_posts`
--
ALTER TABLE `fitblog_posts`
  ADD CONSTRAINT `fitblog_posts_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`);

--
-- Constraints for table `fitblog_post_comments`
--
ALTER TABLE `fitblog_post_comments`
  ADD CONSTRAINT `fitblog_post_comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `fitblog_posts` (`post_id`),
  ADD CONSTRAINT `fitblog_post_comments_ibfk_2` FOREIGN KEY (`username`) REFERENCES `users` (`username`);

--
-- Constraints for table `friends`
--
ALTER TABLE `friends`
  ADD CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON UPDATE CASCADE,
  ADD CONSTRAINT `friends_ibfk_2` FOREIGN KEY (`friend_username`) REFERENCES `users` (`username`) ON UPDATE CASCADE;

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`username`);

--
-- Constraints for table `group_members`
--
ALTER TABLE `group_members`
  ADD CONSTRAINT `group_members_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON UPDATE CASCADE,
  ADD CONSTRAINT `group_members_ibfk_2` FOREIGN KEY (`group_ref_code`) REFERENCES `groups` (`group_ref_code`);

--
-- Constraints for table `interests`
--
ALTER TABLE `interests`
  ADD CONSTRAINT `interests_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`username`);

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `fk_news_users1` FOREIGN KEY (`created_by`) REFERENCES `users` (`username`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_notifications_users1` FOREIGN KEY (`notify_user`) REFERENCES `users` (`username`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_conversations`
--
ALTER TABLE `user_conversations`
  ADD CONSTRAINT `fk_user_conversations_users1` FOREIGN KEY (`primary_user`) REFERENCES `users` (`username`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_conversations_users2` FOREIGN KEY (`secondary_user`) REFERENCES `users` (`username`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_conversation_messages`
--
ALTER TABLE `user_conversation_messages`
  ADD CONSTRAINT `fk_user_conversation_messages_user_conversations1` FOREIGN KEY (`conversation_id`) REFERENCES `user_conversations` (`conversation_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_conversation_messages_users1` FOREIGN KEY (`sender`) REFERENCES `users` (`username`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_conversation_messages_users2` FOREIGN KEY (`receiver`) REFERENCES `users` (`username`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_socials`
--
ALTER TABLE `user_socials`
  ADD CONSTRAINT `fk_user_socials_users1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
