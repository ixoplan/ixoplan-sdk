<?php
namespace abc;
use Ixolit\Dislo\Redirector\Base\RedirectorRequest;
use Ixolit\Dislo\Redirector\Redirector;
use Ixolit\Dislo\Redirector\Rules\Actions\NoRedirection;
use Ixolit\Dislo\Redirector\Rules\Actions\RedirectToUrl;
use Ixolit\Dislo\Redirector\Rules\Actions\SetCookie;
use Ixolit\Dislo\Redirector\Rules\Conditions\UrlCheck;
use Ixolit\Dislo\Redirector\Rules\Rule;
use Ixolit\Dislo\Redirector\Rules\RuleConditionNode;
use Ixolit\Dislo\Redirector\Rules\RuleNode;
use Psr\Http\Message\ResponseInterface;

/**
 * Class RedirectorTest
 */
class RedirectorTest extends \PHPUnit_Framework_TestCase
{

    public function testRedirector1() {

        $urlCheck = new UrlCheck(['comparator' => 'starts_with', 'value' => 'http://']);
        $rootRuleNode = new RuleConditionNode();
        $rootRuleNode->setConditions([$urlCheck])
            ->setMatching('AND')
            ->setThen(new RedirectToUrl(['statusCode' => 307, 'url' => 'https://www.test.ixolit.com']))
            ->setElse(new NoRedirection());
        $rule = new Rule();
        $rule->setName('Rule1')
            ->setRootRuleNode($rootRuleNode);
        $rules = [$rule];

        $redireorRequest = new RedirectorRequest();
        $redireorRequest->setFromUrl('http//test.ixolit.com')
            ->setMethod('POST')
            ->setIpBasedCountryCode('DE');

        $redirectorRequest = new RedirectorRequest();
        $redirectorRequest->setFromUrl('http://www.test.ixolit.com');

        $redirector = new Redirector($rules);

        $redirectorResult = $redirector->evaluate($redirectorRequest);

        $this->assertEquals(true, $redirectorResult->isRedirect());

        $this->assertEquals('https://www.test.ixolit.com', $redirectorResult->getUrl());

        $this->assertEquals(307, $redirectorResult->getStatusCode());

    }

    public function testRedirector2() {

        $urlCheck = new UrlCheck(['comparator' => 'starts_with', 'value' => 'not_matching']);
        $rootRuleNode1 = new RuleConditionNode();
        $rootRuleNode1->setConditions([$urlCheck])
            ->setMatching('AND')
            ->setThen(new RedirectToUrl(['statusCode' => 307, 'url' => 'https://www.test.ixolit.com']));
        $rule1 = new Rule();
        $rule1->setName('Rule1')
            ->setRootRuleNode($rootRuleNode1);
        $rootRuleNode2 = new SetCookie(['cookieName' => 'newCookieName1', 'cookieValue' => 'newCookieValue1']);
        $rootRuleNode2->setNext(new SetCookie(['cookieName' => 'newCookieName2', 'cookieValue' => 'newCookieValue2']));
        $rootRuleNode2->getNext()->setNext(new RedirectToUrl(['statusCode' => 303, 'url' => 'http://redirect.test.ixolit.com']));
        $rule2 = new Rule();
        $rule2->setName('Rule2')
            ->setRootRuleNode($rootRuleNode2);
        $rules = [$rule1, $rule2];

        $redireorRequest = new RedirectorRequest();
        $redireorRequest->setFromUrl('http//test.ixolit.com')
            ->setMethod('POST')
            ->setIpBasedCountryCode('DE');

        $redirectorRequest = new RedirectorRequest();
        $redirectorRequest->setFromUrl('http://www.test.ixolit.com');

        $redirector = new Redirector($rules);

        $redirectorResult = $redirector->evaluate($redirectorRequest);

        $this->assertEquals(true, $redirectorResult->isRedirect());

        $this->assertEquals(303, $redirectorResult->getStatusCode());

        $this->assertEquals('http://redirect.test.ixolit.com', $redirectorResult->getUrl());

        $this->assertCount(2, $redirectorResult->getCookies());


    }

}