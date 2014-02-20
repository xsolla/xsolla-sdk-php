<?php
namespace Xsolla\SDK\Tests\Widget;

use Xsolla\SDK\Widget\MobilePayment;

class MobilePaymentTest extends WidgetTestCase
{
    protected $defaultUrl = 'https://secure.xsolla.com/paystation2/?pid=1738&theme=201&marketplace=landing&project=7096&sign=457a3f06ea55593b6204b992963cf762';

    protected $urlWithHiddenParameters = 'https://secure.xsolla.com/paystation2/?local=EN&pid=1738&theme=201&marketplace=landing&project=7096&hidden=local&sign=457a3f06ea55593b6204b992963cf762';

    protected $urlWithUserDetailsAndClearedSignedParameters = 'https://secure.xsolla.com/paystation2/?v1=user_v1&v2=user_v2&v3=user_v3&email=user_email&userip=user_userIp&phone=user_phone&pid=1738&theme=201&marketplace=landing&project=7096&signparams=project%2Csignparams&sign=bdec2de8e6090adeb6516a70366c0524';

    protected $urlWithInvoiceAndWithoutSignparams = 'https://secure.xsolla.com/paystation2/?out=1.11&currency=EUR&pid=1738&theme=201&marketplace=landing&project=7096&sign=04fc08628461bd41d2174140c6f1c18e';

    protected $fullUrl = 'https://secure.xsolla.com/paystation2/?local=EN&country=US&limit=14&v1=user_v1&v2=user_v2&v3=user_v3&email=user_email&userip=user_userIp&phone=user_phone&out=1.11&currency=EUR&pid=1738&theme=201&marketplace=landing&project=7096&hidden=limit%2Cv1%2Cv2%2Cv3%2Cemail%2Cuserip%2Cphone%2Cout%2Ccurrency&signparams=limit%2Cproject%2Csignparams&sign=0fd1a6fed019a5922f41a41cccbbca38';

    public function setUp()
    {
        parent::setUp();
        $this->widget = new MobilePayment($this->project);
    }
}
