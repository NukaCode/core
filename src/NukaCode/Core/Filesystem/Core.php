<?php namespace NukaCode\Core\Filesystem;

class Core {

    protected function verifyCommand($package)
    {
        $validator = $this->validator->make((array)$package, $this->rules);

        if ($validator->fails()) {
            $messages = $validator->messages();

            foreach ($messages->all() as $message) {
                throw new \InvalidArgumentException($message);
            }
        }
    }
}