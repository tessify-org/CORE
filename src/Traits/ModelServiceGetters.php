<?php

namespace Tessify\Core\Traits;

/**
 * ModelServiceGetters
 * 
 * This trait abstracts away all the common getter methods that all ModelServices share.
 * 
 * Requirements:
 *  - Private property called 'model' with the namespaced classname as a string as value
 *  - Private properties called 'records' and 'preloadedRecords' which will be Illuminate\Support\Collection's
 *  - Private method called preload() which takes and returns the model instance in question
 * 
 * @author      Nick Verheijen <nick.verheijen@minbzk.nl>
 * @version     1.0.0
 */

trait ModelServiceGetters
{
    public function getAll()
    {
        if (is_null($this->records))
        {
            $this->records = call_user_func($this->model."::all");
        }

        return $this->records;
    }

    public function getAllPreloaded()
    {
        if (is_null($this->preloadedRecords))
        {
            $out = [];

            foreach ($this->getAll() as $record)
            {
                $clonedRecord = clone $record;

                $out[] = $this->preload($clonedRecord);
            }

            $this->preloadedRecords = collect($out);
        }

        return $this->preloadedRecords;
    }

    public function find($id)
    {
        foreach ($this->getAll() as $record)
        {
            if ($record->id == $id)
            {
                return $record;
            }
        }

        return false;
    }

    public function findPreloaded($id)
    {
        foreach ($this->getAllPreloaded() as $record)
        {
            if ($record->id == $id)
            {
                return $record;
            }
        }

        return false;
    }
}