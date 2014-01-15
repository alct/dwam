# DWaM: Domain Whack-a-Mole

_DWaM is a proof of concept. It is a web application requesting information from multiple DNS servers in a single shot._

Current Version: **0.1**

## Requirements

* PHP
* Composer
* Net_DNS2 (via Composer)

## Installation instructions

1. Clone the repository

        git clone https://github.com/alct/dwam.git

2. Rename the file containing servers list

        mv servers.example.json servers.json

3. Install the dependencies

        composer update

4. Profit

## Licence

Copyright &copy; 2014- André LOCONTE

This program is free software: you can redistribute it and/or modify it under the terms of the [GNU Affero General Public License](https://gnu.org/licenses/agpl.html) as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

This programe uses the [Stripe flag set](http://dribbble.com/shots/1089488-Stripe-Flag-Set) created by Benjamin De Cock.