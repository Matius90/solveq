<?php


namespace Core\Responses;


use Mpdf\Mpdf;

class PdfResponse
{
    private $smarty;
    private $templateHTML;

    public function __construct(string $templateName, array $data = [])
    {
        $this->prepareTemplate($templateName, $data);
        $this->returnPDF();
    }

    public function prepareTemplate(string $templateName, array $data): void
    {
        $this->smarty = new \Smarty();
        $this->smarty->setTemplateDir('Templates');
        $this->smarty->assign($data);
        $this->templateHTML = $this->smarty->fetch($templateName.".tpl");
    }

    private function returnPDF() {
        $mpdf = new Mpdf();
//        var_dump($this->templateHTML);exit;
        $mpdf->WriteHTML($this->templateHTML);
        $mpdf->Output("Transactions.pdf", "I");
    }
}