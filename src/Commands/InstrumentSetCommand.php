<?php
/**
 * Plugins which are to be distributed should define their own namespace in order to avoid conflicts. To do so, use
 * the PSR-4 standard and add an autoload section to your composer.json.
 *
 * Development or internal-only plugins can omit the namespace declaration and the autoload section in composer.json.
 * The command will then use the global namespace.
 */

namespace Pantheon\TerminusInstrumentSet;


/**
 * It is not strictly necessary to extend the TerminusCommand class but doing so causes a number of helpful
 * objects (logger, session, etc) to be automatically provided to your class by the dependency injection container.
 */
use Pantheon\Terminus\Commands\TerminusCommand;
use Pantheon\Terminus\Commands\WorkflowProcessingTrait;
use Pantheon\Terminus\Exceptions\TerminusException;
use Pantheon\Terminus\Site\SiteAwareInterface;
use Pantheon\Terminus\Site\SiteAwareTrait;


/**
 * Say hello to the user
 *
 * When you rename this class, make sure the new name ends with "Command" so that Terminus can find it.
 */
class InstrumentSetCommand extends TerminusCommand {
  /**
   *
   *  Associates an existing payment method with a site.
   *
   * @authorize
   *
   * @command instrument:set
   *
   * @param string $site_name Site name
   * @param string $payment_method Payment method UUID
   *
   * @usage <site> <payment_method> Associates <payment_method> with <site>.
   */
  public function add($site_name, $payment_method) {
    $site = $this->getSite($site_name);

    preg_match(
      '/[a-f0-9]{8}\-[a-f0-9]{4}\-4[a-f0-9]{3}\-(8|9|a|b)[a-f0-9]{3}\-[a-f0-9]{12}/',
      $payment_method,
      $matches
    );
    if (empty($matches)) {
      throw new TerminusException('The instrument must be identified by its UUID.');
    }

    $workflow = $site->addPaymentMethod($payment_method);
    $retry_interval = $this->getConfig()->get('http_retry_delay_ms', 100);
    while (!$workflow->isFinished()) {
      $workflow->fetch();
      usleep($retry_interval * 1000);
    }

    $this->log()->notice(
      '{method} has been applied to the {site} site.',
      ['method' => $payment_method, 'site' => $site->get('name'),]
    );
  }
}
