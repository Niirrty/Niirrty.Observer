<?php

error_reporting( E_ALL );
ini_set( 'display_errors', 'On' );

include dirname( __DIR__ ) . '/vendor/autoload.php';

use \Niirrty\Observer\IObserver;
use \Niirrty\Observer\IObservable;
use \Niirrty\Observer\Observable;


/**
 * Defines a class that …
 */
class MyObserver implements IObserver
{


    /**
     * Is called by an observed observable to inform the observer about an update.
     *
     * @param IObservable $observable The observed observable that should be updated
     * @param mixed|null  $extras     Optional data from observed
     */
    public function onUpdate( IObservable $observable, mixed $extras = null )
    {
        echo '- Observable change property ';
        if ( \is_array( $extras ) && isset( $extras[ 'property' ] ) )
        {
            echo '"' . $extras[ 'property' ], '" ';
        }
        echo "to a new value\n";
    }

    /**
     * Is called by an observable to inform, that the observed defined observable will now inform the
     * observer about something.
     *
     * @param IObservable $observable
     * @return mixed
     */
    public function onSubscribe( IObservable $observable ) : mixed
    {
        echo "- Im now subscribed to a new observable\n";
        return true;
    }

    /**
     * Is called by an observable to inform it that the observed defined observable will not longer inform the
     * observer about something.
     *
     * @param IObservable $observable
     * @return mixed
     */
    public function onUnsubscribe( IObservable $observable ) : mixed
    {
        echo "- Im now unsubcribed to a observable\n";
        return true;
    }


}

class MyObservable extends Observable
{

    private $_name;
    private $_value;

    /**
     * …
     *
     * @param  mixed $name
     * @return MyObservable
     */
    public function setName( $name )
    {

        if ( $this->_name === $name ) { return $this; }

        $this->_name = $name;

        $this->notify( [ 'property' => 'name' ] );

        return $this;

    }

    /**
     * …
     *
     * @param  mixed $value
     * @return MyObservable
     */
    public function setValue( $value )
    {

        if ( $this->_value === $value ) { return $this; }

        $this->_value = $value;

        $this->notify( [ 'property' => 'value' ] );

        return $this;

    }

    /**
     * @return mixed
     */
    public function getValue()
    {

        return $this->_value;

    }

    public function __construct( $name, $value )
    {
        parent::__construct();
        $this->_name  = $name;
        $this->_value = $value;
    }

    public function getName()
    {
        return $this->_name;
    }

}


$observer = new MyObserver();
$observable = new MyObservable( 'foo', 1 );
$observable->subscribe( $observer );


$observable->setName( 'bar' );
$observable->setValue( true );
$observable->unsubscribe( $observer );
$observable->setName( 'baz' );
$observable->subscribe( $observer );
$observable->setName( 'blub' );

