<?php namespace NukaCode\Core\Controllers\Admin\Edit;

use NukaCode\Core\Http\Requests\Admin\Edit\Preference;
use NukaCode\Core\Repositories\Contracts\PreferenceRepositoryInterface;
use NukaCode\Core\Requests\Ajax;

class PreferenceController extends \BaseController {

    /**
     * @var Ajax
     */
    private $ajax;

    /**
     * @var PreferenceRepositoryInterface
     */
    private $preference;

    public function __construct(PreferenceRepositoryInterface $preference, Ajax $ajax)
    {
        parent::__construct();
        $this->ajax       = $ajax;
        $this->preference = $preference;
    }

    public function getIndex($id)
    {
        $preference = $this->preference->find($id);

        $this->setViewData(compact('preference'));
    }

    public function postIndex(Preference $request, $id)
    {
        // Update the user
        $this->preference->findFirst($request->only('id'));
        $this->preference->update($request->all());

        // Send the response
        return $this->ajax->sendResponse();
    }

} 