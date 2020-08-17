ALTER TABLE `engine4_sesgroup_groups` CHANGE `member_count` `member_count` INT(1) NULL DEFAULT '0';
UPDATE `engine4_sesgroup_groups` SET member_count = member_count -1 WHERE member_count != 0;