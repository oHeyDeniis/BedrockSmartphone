<?php

namespace oheydeniis\bs\elements;

class SoundUIElement extends UiElement
{

    /**
     * Name of the sound defined in the
     * RP/sounds/sound_definitions.json file that
     * plays when the pressed event is fired
     * @return $this
     */
    public function setSoundName(string $name) : self{
        $this->data["sound_name"] = $name;
        return $this;
    }

    /**
     * @return $this
     */
    public function setSoundVolume(float $volume) : self{
        $this->data["sound_volume"] = $volume;
        return $this;
    }

    /**
     * @return $this
     */
    public function setSoundPitch(float $pitch) : self{
        $this->data["sound_pitch"] = $pitch;
        return $this;
    }

    /**
     * @return $this
     */
    public function addSounds() : self{
        //todo
        $this->data["sounds"] = "";
        return $this;
    }
}