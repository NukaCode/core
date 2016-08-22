- [Using the Installer](#using-installer)
- [Composer](#composer)
    - [Create Project](#create-project)
    - [Just Core](#just-core)
- [Cloning the Repository](#cloning-repository)

# Installation

<a name="using-installer"></a>
## Using the Installer
`composer global require "nukacode/installer=~1.0"`

`nukacode new <directory>`

> You can use the ``--slim`` option at the end to get a minimal version.

The full version comes with nukacode core, menu and users.  The slim variant comes with only core and menu.

<a name="composer"></a>
## Composer
<a name="create-project"></a>
### Create Project
`composer create-project nukacode/nukacode <path>`

Using NukaCode it will pull in Core and Menu automatically.

<a name="just-core"></a>
### Just Core
`composer require nukacode/core:~2.0`

<a name="cloning-repository"></a>
## Cloning the Repository
`git clone git@github.com:NukaCode/NukaCode.git ./`
