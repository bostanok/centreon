<?php
namespace Centreon\Domain\Repository;

use Centreon\Infrastructure\CentreonLegacyDB\ServiceEntityRepository;
use PDO;

class ServiceGroupRepository extends ServiceEntityRepository
{

    /**
     * Export
     * 
     * @todo restriction by poller
     * 
     * @param int $pollerId
     * @return array
     */
    public function export(int $pollerId): array
    {
        $sql = <<<SQL
SELECT
    t.*
FROM servicegroup AS t
INNER JOIN servicegroup_relation AS sgr ON sgr.servicegroup_sg_id = t.sg_id
LEFT JOIN hostgroup AS hg ON hg.hg_id = sgr.hostgroup_hg_id
LEFT JOIN hostgroup_relation AS hgr ON hgr.hostgroup_hg_id = hg.hg_id
INNER JOIN ns_host_relation AS hr ON hr.host_host_id = sgr.host_host_id OR hr.host_host_id = hgr.host_host_id
WHERE hr.nagios_server_id = :id
GROUP BY t.sg_id
SQL;

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $pollerId, PDO::PARAM_INT);
        $stmt->execute();

        $result = [];

        while ($row = $stmt->fetch()) {
            $result[] = $row;
        }

        return $result;
    }
}
