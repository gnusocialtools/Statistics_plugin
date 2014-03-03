<?php

if (!defined('GNUSOCIAL')) { exit(1); }

class StatisticsAction extends Action
{
    
    var $plugins = array();
    
    protected function prepare(array $args=array())
    {
        parent::prepare($args);
        
        $args = array();
        
        Event::handle('PluginVersion', array(&$this->plugins));
        
        header('Content-type: text/plain; charset=utf-8');
        
        return true;
    }
    
    protected function handle()
    {
        $stats = array();
        # Inserting some vital stats.
        $stats["instance_name"] = common_config("site", "name");
        $stats["instance_address"] = common_config("site", "server");
        $stats["instance_with_ssl"] = common_config("site", "ssl");
        $stats["instance_version"] = GNUSOCIAL_VERSION;
        $stats["twitter"] = common_config("twitter", "enabled");
        $stats["twitterimport"] = common_config("twitterimport", "enabled");
        
        # Get users count.
        $user = new User();
        $user->query("SELECT COUNT(id) FROM user;");
        while ($user->fetch())
        {
            $stats["users_count"] = $user->COUNT(id);
        }
        
        # Add all users logins and fullnames.
        $user = new User();
        $user->query("SELECT id, nickname, fullname FROM profile WHERE profileurl LIKE \"%" . $stats["instance_address"] . "%\" and profileurl NOT LIKE \"%group%\";");
        while ($user->fetch())
        {
            $stats["users"][$user->nickname] = array(
                                                "id" => $user->id,
                                                "nickname" => $user->nickname,
                                                "fullname" => $user->fullname
                                                );
        }
        
        # Add local groups.
        $group = new Local_group();
        $group->query("SELECT * FROM local_group;");
        while ($group->fetch())
        {
            $stats["groups"][$group->group_id] = array(
                                                "id" => $group->group_id,
                                                "name" => $group->nickname
                                                );
        }
                
        # Get notices count.
        $notice = new Notice();
        $notice->query("SELECT COUNT(id) FROM notice;");
        while ($notice->fetch())
        {
            $stats["notices_count"] = $notice->COUNT(id);
        }
        
        # Fill with plugins :)
        $stats["plugins"] = array();
        
        foreach ($this->plugins as $plugin)
        {
            $stats["plugins"][$plugin["name"]] = array(
                                                "name" => $plugin["name"],
                                                "version" => $plugin["version"],
                                                "homepage" => $plugin["homepage"]
                                                );
        }
        
        # Afterall, print this. In json.
        echo json_encode($stats);
    }
}

?>
