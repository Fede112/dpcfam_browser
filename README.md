# Web browser for DPCfam project 

Web application to provide basic navigation tools to query the DPCfam dataset.
The app was developed using the content manager ProcessWire and MySQL (with InnoDB engine).
Latest version supports querying the system using MCs, Pfam families or UniProt ids.

The webpage is currently currently online at: [dpcfam.areasciencepark.it](https://dpcfam.areasciencepark.it)


### TODO:

- add full seeds - OK
- add datatable to metacluster.php
- modify protein plots (allow to enable/disable domains) - OK - BUG: more than two domains with same name
- update CC, DIS, TM
- make search bar input more flexible (MC1,MC2,MC3 == MC1, MC2, MC3)
- make top right bar accept any input (MC, prot, pfam)
- long-term: improve speed of protein search
- pie chart with content of metacluster (including DAC but also the other pfam families)
- add MSA viewer
