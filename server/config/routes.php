<?php

// users routes


// default routes
// Router::add('^admin$', ['controller' => 'Main', 'action' => 'index', 'prefix' => 'admin']);
// Router::add('^admin/?(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$', ['prefix' => 'admin']);

// Router::add('^$', ['controller' => 'Main', 'action' => 'index']);
Router::add('news/all', ['controller' => 'News', 'action' => 'all']);
Router::add('news/add', ['controller' => 'News', 'action' => 'add']);
Router::add('news/update', ['controller' => 'News', 'action' => 'update']);
Router::add('news/one/?(?P<param>[0-9-]+)?$', ['controller' => 'News', 'action' => 'one']);
Router::add('news/delete/?(?P<param>[0-9-]+)?$', ['controller' => 'News', 'action' => 'delete']);

// Router::add('news/all', ['controller' => 'News', 'action' => 'all']);
// Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?/?(?P<param>[0-9-]+)?$');