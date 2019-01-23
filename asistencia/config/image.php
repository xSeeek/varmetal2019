<?php

return [

  'public' => [
    'driver' => 'local',
    'path' => public_path()
  ],
  'asistencia' => [
    'driver' => 'filesystem',
    'disk' => 'asistencia',
    'path' => null,
    'cache' => true,
    'cache_path' => storage_path('image/cache')
  ]
];
