<?php

namespace Stelssoft\YiiCmsCore;

class CmsMigration
{
    public function migrateModule($moduleName)
    {

    }

    public function actionUp($limit = 0)
    {
        $migrations = $this->getNewMigrations();
        if (empty($migrations)) {
            return false;
        }

        $total = count($migrations);
        $limit = (int) $limit;
        if ($limit > 0) {
            $migrations = array_slice($migrations, 0, $limit);
        }

        $applied = 0;
        if ($this->confirm('Apply the above ' . ($n === 1 ? 'migration' : 'migrations') . '?')) {
            foreach ($migrations as $migration) {
                if (!$this->migrateUp($migration)) {

                }
                $applied++;
            }

    }
}
