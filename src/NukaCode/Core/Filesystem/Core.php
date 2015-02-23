<?php namespace NukaCode\Core\Filesystem;

abstract class Core {

    protected $validator;

    protected $rules;

    protected function verifyCommand($package)
    {
        $validator = $this->validator->make((array)$package, $this->rules);

        if ($validator->fails()) {
            $messages = $validator->messages();

            foreach ($messages->all() as $field => $message) {
                throw new \InvalidArgumentException($message);
            }
        }
    }
}