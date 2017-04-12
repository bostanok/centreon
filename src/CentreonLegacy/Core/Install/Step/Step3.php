<?php
/*
 * Copyright 2005-2015 Centreon
 * Centreon is developped by : Julien Mathis and Romain Le Merlus under
 * GPL Licence 2.0.
 * 
 * This program is free software; you can redistribute it and/or modify it under 
 * the terms of the GNU General Public License as published by the Free Software 
 * Foundation ; either version 2 of the License.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A 
 * PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License along with 
 * this program; if not, see <http://www.gnu.org/licenses>.
 * 
 * Linking this program statically or dynamically with other modules is making a 
 * combined work based on this program. Thus, the terms and conditions of the GNU 
 * General Public License cover the whole combination.
 * 
 * As a special exception, the copyright holders of this program give Centreon 
 * permission to link this program with independent modules to produce an executable, 
 * regardless of the license terms of these independent modules, and to copy and 
 * distribute the resulting executable under terms of Centreon choice, provided that 
 * Centreon also meet, for each linked independent module, the terms  and conditions 
 * of the license of that module. An independent module is a module which is not 
 * derived from this program. If you modify this program, you may extend this 
 * exception to your version of the program, but you are not obliged to do so. If you
 * do not wish to do so, delete this exception statement from your version.
 * 
 * For more information : contact@centreon.com
 *
 */

namespace CentreonLegacy\Core\Install\Step;

class Step3 extends AbstractStep
{
    public function getContent()
    {
        $installDir = __DIR__ . '/../../../../../www/install';
        require_once $installDir . '/steps/functions.php';
        $template = getTemplate($installDir . '/steps/templates');

        $parameters = $this->getEngineParameters();

        $template->assign('title', _('Monitoring engine information'));
        $template->assign('step', 3);
        $template->assign('parameters', $parameters);
        return $template->fetch('content.tpl');
    }

    public function getEngineParameters()
    {
        $configuration = $this->getConfiguration();
        $engineConfiguration = $this->getEngineConfiguration();
        $file = __DIR__ . '/../../../../../www/install/var/engines/centreon-engine';
        $lines = explode("\n", file_get_contents($file));

        $parameters = array();
        foreach ($lines as $line) {
            if (!$line || $line[0] == '#') {
                continue;
            }
            list($key, $label, $required, $paramType, $default) = explode(';', $line);
            $val = $default;
            $configurationKey = strtolower(str_replace(' ', '_', $key));
            if (isset($engineConfiguration[$configurationKey])) {
                $val = $engineConfiguration[$configurationKey];
            } elseif (isset($configuration[$configurationKey])) {
                $val = $configuration[$configurationKey];
            }
            $parameters[$configurationKey] = array(
                'name' => $configurationKey,
                'type' => $paramType,
                'label' => $label,
                'required' => $required,
                'value' => $val
            );
        }

        return $parameters;
    }

    public function getEngineConfiguration()
    {
        $configuration = array();

        $configurationFile = __DIR__ . "/../../../../../www/install/tmp/engine.json";
        if ($this->dependencyInjector['filesystem']->exists($configurationFile)) {
            $configuration =  json_decode(file_get_contents($configurationFile), true);
        }

        return $configuration;
    }

    public function setEngineConfiguration($parameters)
    {
        $configurationFile = __DIR__ . "/../../../../../www/install/tmp/engine.json";
        file_put_contents($configurationFile, json_encode($parameters));
    }
}