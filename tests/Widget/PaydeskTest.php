<?php
namespace Xsolla\SDK\Tests\Widget;

use Xsolla\SDK\Widget\Paydesk;

class PaydeskTest extends WidgetTestCase
{
    protected $defaultUrl = 'https://secure.xsolla.com/paystation2/?marketplace=paydesk&project=7096&sign=094eb3c634f2612dead38608dc20eaec';

    protected $urlWithHiddenParameters = 'https://secure.xsolla.com/paystation2/?local=EN&marketplace=paydesk&project=7096&hidden=local&sign=094eb3c634f2612dead38608dc20eaec';

    protected $urlWithUserDetailsAndClearedSignedParameters = 'https://secure.xsolla.com/paystation2/?v1=user_v1&v2=user_v2&v3=user_v3&email=user_email&userip=user_userIp&phone=user_phone&marketplace=paydesk&project=7096&signparams=project%2Csignparams&sign=bdec2de8e6090adeb6516a70366c0524';

    protected $urlWithInvoiceAndWithoutSignparams = 'https://secure.xsolla.com/paystation2/?out=1.11&currency=EUR&marketplace=paydesk&project=7096&sign=5bbc52cd72d7b3491025a7d6cca0cb70';

    protected $fullUrl = 'https://secure.xsolla.com/paystation2/?local=EN&country=US&limit=14&v1=user_v1&v2=user_v2&v3=user_v3&email=user_email&userip=user_userIp&phone=user_phone&out=1.11&currency=EUR&marketplace=paydesk&project=7096&hidden=limit%2Cv1%2Cv2%2Cv3%2Cemail%2Cuserip%2Cphone%2Cout%2Ccurrency&signparams=limit%2Cproject%2Csignparams&sign=0fd1a6fed019a5922f41a41cccbbca38';

    public function setUp()
    {
        parent::setUp();
        $this->widget = new Paydesk($this->project);
    }
}
