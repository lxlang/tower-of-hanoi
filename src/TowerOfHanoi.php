<?php

/**
 * Class Hanoi
 */
class TowerOfHanoi
{
    const FIELD_DISC = 'DISC';
    const FIELD_FROM = 'FROM';
    const FIELD_TO = 'TO';
    const LINE_LENGTH = 100;
    const THRESHOLD = 500000;
    const THRESHOLD_LINE = self::THRESHOLD * self::LINE_LENGTH;

    private $discs = 0;
    private $moveNumber = 0;
    private $stack1 = [];
    private $stack2 = [];
    private $stack3 = [];
    private $solution = [];
    private $targets = [];

    public function __construct($discs)
    {
        $this->discs = $discs;
        $this->init();
    }

    public function start()
    {
        try {
            echo "Start calaculating Tower of Hanoi with {$this->discs} discs. This will take {$this->moveAmount()} moves!\n\n";
            $this->calculate($this->discs);
        } catch (\Exception $e) {
            echo "\n {$e->getMessage()}\n";
        }
    }

    /**
     * Initiate stacks with discs
     */
    protected function init()
    {
        for ($disc = $this->discs; $disc >= 1; $disc--) {
            $this->stack1 [] = $disc;
        }
    }

    /**
     * Predict the number of moves which are necessary to solve the tower
     * @return number
     */
    protected function moveAmount()
    {
        return pow(2, $this->discs) - 1;
    }

    /**
     * Recursive function to calculate the tower
     *
     * @param int $n
     * @param int $from
     * @param int $to
     * @param int $via
     * @throws Exception
     */
    protected function calculate($n, $from = 1, $to = 3, $via = 2)
    {
        if ($n === 1) {
            ///this is an actual move we can make
            $this->moveNumber++;

            //lets print some output for the humans waiting
            $this->printStatus($this->moveNumber);

            $currentDisc = $this->moveDiscOnStacks($from, $to);

            if ($this->isTarget($this->moveNumber)) {
                // this move is in our targets list
                $this->solution[$this->moveNumber] = [
                    self::FIELD_FROM => $from,
                    self::FIELD_TO => $to,
                    self::FIELD_DISC => $currentDisc,
                ];

                if (count($this->targets) == 0) {
                    //all targets have been found - that's it
                    throw new Exception('Done');
                }
            }
        } else {
            //recursive magic
            $this->calculate($n - 1, $from, $via, $to);
            $this->calculate(1, $from, $to, $via);
            $this->calculate($n - 1, $via, $to, $from);
        }
    }

    /**
     * Eye-candy for humans
     *
     * @param $moveNumber
     */
    protected function printStatus($moveNumber)
    {
        if ($moveNumber % self::THRESHOLD == 0) {
            print '.';
        }

        if ($moveNumber % self::THRESHOLD_LINE == 0) {
            $percentageRounded = round($moveNumber / $this->moveAmount() * 100, 2);
            print " {$percentageRounded}%\n";
        }
    }

    /**
     * Move Discs on stacks. Return moved disc number
     *
     * @param int $from
     * @param int $to
     * @return int moved disc number
     * @throws Exception if the stacks are not known to the system
     */
    protected function moveDiscOnStacks($from, $to)
    {

        switch ($from) {
            case 1:
                $currentDisc = array_pop($this->stack1);
                break;
            case 2:
                $currentDisc = array_pop($this->stack2);
                break;
            case 3:
                $currentDisc = array_pop($this->stack3);
                break;
            default:
                throw new Exception('Only three stacks are implemented');
        }

        switch ($to) {
            case 1:
                array_push($this->stack1, $currentDisc);
                break;
            case 2:
                array_push($this->stack2, $currentDisc);
                break;
            case 3:
                array_push($this->stack3, $currentDisc);
                break;
            default:
                throw new Exception('Only three stacks are implemented');
        }

        return $currentDisc;
    }

    /**
     * Identifies targets and removes them from the list
     *
     * @param $moveNumber
     * @return bool
     */
    protected function isTarget($moveNumber)
    {
        if (in_array($moveNumber, $this->targets)) {
            unset($this->targets[$moveNumber]);
            return $moveNumber;
        }

        return false;
    }

    /**
     * Get stack number where the disc was moved in specified move
     *
     * @param $moveNumber
     * @return bool
     */
    public function getFrom($moveNumber)
    {
        return $this->getValue($moveNumber, self::FIELD_FROM);
    }

    /**
     * Get desired value from solution array
     *
     * @param $moveNumber
     * @param $field
     * @return bool
     */
    protected function getValue($moveNumber, $field)
    {
        if (empty($this->solution)) {
            throw new InvalidArgumentException('Please start calculation first ->start()');
        }

        if (!isset($this->solution[$moveNumber][$field])) {
            throw new InvalidArgumentException($moveNumber . ' was not saved!');
        }

        return $this->solution[$moveNumber][$field];
    }

    /**
     * Gets the target stack in specified move
     *
     * @param $moveNumber
     * @return bool
     */
    public function getTo($moveNumber)
    {
        return $this->getValue($moveNumber, self::FIELD_TO);
    }

    /**
     * This is only available after calculation
     * Gets the moved disc in specified move
     *
     * @param $moveNumber
     * @return bool
     */
    public function getMovedDisc($moveNumber)
    {
        return $this->getValue($moveNumber, self::FIELD_DISC);
    }

    /**
     * Add moveNumbers to an array. The moves with these numbers will be saved during calculation
     * and be available afterward
     *
     * @param array $targets
     */
    public function addTargets(array $targets)
    {
        foreach ($targets as $moveNumber) {
            $this->targets[$moveNumber] = $moveNumber;
        }
    }
}
