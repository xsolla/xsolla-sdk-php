<?php

namespace Xsolla\SDK\Protocol;

use Symfony\Component\HttpFoundation\Request;
use Xsolla\SDK\Exception\InvalidRequestException;
use Xsolla\SDK\Exception\InvalidSignException;
use Xsolla\SDK\Exception\UnprocessableRequestException;
use Xsolla\SDK\Exception\WrongCommandException;
use Xsolla\SDK\Protocol\Command\Command;
use Xsolla\SDK\Validator\IpChecker;
use Xsolla\SDK\Project;

abstract class Protocol
{
    protected $response;

    protected $project;

    protected $ipChecker;

    protected $commandFactory;

    protected $xmlResponseBuilder;

    protected $currentCommand;

    public function __construct(Project $project, XmlResponseBuilder $xmlResponseBuilder, IpChecker $ipChecker = null)
    {
        $this->project = $project;
        $this->xmlResponseBuilder = $xmlResponseBuilder;
        $this->ipChecker = $ipChecker;
    }

    /**
     * @return \Xsolla\SDK\Project
     */
    public function getProject()
    {
        return $this->project;
    }

    public function doCheck(Request $request)
    {
        if ($this->ipChecker) {
            $this->ipChecker->checkIp($request->getClientIp());
        }
        if (!$request->query->get('command')) {
            throw new WrongCommandException(sprintf(
                'No command in request. Available commands are: "%s".',
                join('", "', $this->getProtocolCommands())
            ));
        }
    }

    public function run(Request $request)
    {
        try {
            $this->doCheck($request);
            $commandResponse = $this->doRun($request);

        } catch (UnprocessableRequestException $e) {
            $commandResponse = array(
                'result' => $this->currentCommand->getUnprocessableRequestResponseCode(),
                $this->currentCommand->getCommentFieldName() => trim('Unprocessable request. ' . $e->getMessage())
            );
        } catch (InvalidSignException $e) {
            $commandResponse = array(
                'result' => $this->currentCommand->getInvalidSignResponseCode(),
                $this->currentCommand->getCommentFieldName() => $e->getMessage()
            );
        } catch (InvalidRequestException $e) {
            $commandResponse = array(
                'result' => $this->currentCommand->getInvalidRequestResponseCode(),
                $this->currentCommand->getCommentFieldName() => $e->getMessage()
            );

        } catch (WrongCommandException $e) {
            $commandResponse = $this->getResponseForWrongCommand($e->getMessage());

        } catch (\Exception $e) {
            $commandResponse = array(
                'result' => $this->currentCommand->getTemporaryServerErrorResponseCode(),
                $this->currentCommand->getCommentFieldName() => $e->getMessage()
            );
        }

        return $this->xmlResponseBuilder->get($commandResponse);
    }

    /**
     * @param  Request $request
     * @return array
     */
    public function doRun(Request $request)
    {
        $this->currentCommand = $this->commandFactory->getCommand($this, $request->query->get('command'));

        return $this->currentCommand->getResponse($request);
    }

    // @codeCoverageIgnoreStart
    abstract public function getProtocolCommands();

    abstract public function getResponseForWrongCommand($message);
    // @codeCoverageIgnoreEnd
}
