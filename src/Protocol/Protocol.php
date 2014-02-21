<?php

namespace Xsolla\SDK\Protocol;

use Symfony\Component\HttpFoundation\Request;
use Xsolla\SDK\Exception\InvalidRequestException;
use Xsolla\SDK\Exception\InvalidSignException;
use Xsolla\SDK\Exception\UnprocessableRequestException;
use Xsolla\SDK\Exception\WrongCommandException;
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

    protected $unprocessableRequestResponseCode;

    protected $commentFieldName;

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

    public function run(Request $request)
    {
        try {
            $commandResponse = $this->doRun($request);
        } catch (UnprocessableRequestException $e) {
            $commandResponse = $this->getUnprocessableRequestResponse($e);
        } catch (WrongCommandException $e) {
            $commandResponse = $this->getResponseForWrongCommand($e->getMessage());
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
        } catch (\Exception $e) {
            $commandResponse = array(
                'result' => $this->currentCommand->getTemporaryServerErrorResponseCode(),
                $this->currentCommand->getCommentFieldName() => $e->getMessage()
            );
        }

        return $this->xmlResponseBuilder->get($commandResponse);
    }

    protected function doRun(Request $request)
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
        $this->currentCommand = $this->commandFactory->getCommand($this, $request->query->get('command'));

        return $this->currentCommand->getResponse($request);
    }

    protected function getUnprocessableRequestResponse(\Exception $e)
    {
        if ($this->currentCommand) {
            $code = $this->currentCommand->getUnprocessableRequestResponseCode();
            $commentFieldName = $this->currentCommand->getCommentFieldName();
        } else {
            $code = $this->unprocessableRequestResponseCode;
            $commentFieldName = $this->commentFieldName;

        }
        $commandResponse = array(
            'result' => $code,
            $commentFieldName => $e->getMessage()
        );
        return $commandResponse;
    }

    // @codeCoverageIgnoreStart
    abstract public function getProtocolCommands();

    abstract public function getResponseForWrongCommand($message);
    // @codeCoverageIgnoreEnd
}
