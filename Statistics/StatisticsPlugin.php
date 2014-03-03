<?php

class StatisticsPlugin extends Plugin {

    public function onRouterInitialized($m)
    {
        $m->connect('main/statistics', array('action' => 'statistics'));
    }

    public function onPluginVersion(&$versions)
    {
        $versions[] = array('name' => 'Statistics',
                            'version' => '0.1',
                            'author' => 'Stanislav "pztrn" Nikitin',
                            'homepage' => 'http://en.pztrn.name/',
                            'description' =>
                            // TRANS: Plugin description.
                            _m('Display some statistics for this GNU Social instance.'));
        return true;
    }

}

?>
