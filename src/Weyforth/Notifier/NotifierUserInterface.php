<?php
/**
 * User interface to use with Notifier class.
 *
 * @author    Mike Farrow <contact@mikefarrow.co.uk>
 * @license   Proprietary/Closed Source
 * @copyright Mike Farrow
 */

namespace Weyforth\Notifier;

interface NotifierUserInterface
{


    /**
     * Provide an email address to pass to the notify function.
     *
     * @return string
     */
    public function emailAddress();


}
