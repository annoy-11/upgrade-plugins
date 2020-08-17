UPDATE `engine4_activity_actiontypes` SET `type` = 'seseventvideo_video_favourite' WHERE `engine4_activity_actiontypes`.`type` = 'seseventvideo_favourite_video';

UPDATE `engine4_activity_actions` SET `type` = 'seseventvideo_video_favourite' WHERE `engine4_activity_actions`.`type` = 'seseventvideo_favourite_video';