--[[
Copyright (c) 2010 MTA: Paradise

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.
]]

addCommandHandler( "freecam",
	function( player, commandName )
  if not hasObjectPermissionTo ( player, "command.freecam", false ) then return end
		if not isPedInVehicle( player ) then
			if isPlayerFreecamEnabled( player ) then
				setPlayerFreecamDisabled( player )
                unbindKey( player, "w", "down", "73ns03nsi3bao3n2u20oan3g" )	
                unbindKey( player, "a", "down", "73ns03nsi3bao3n2u20oan3g" )	
                unbindKey( player, "s", "down", "73ns03nsi3bao3n2u20oan3g" )	
                unbindKey( player, "d", "down", "73ns03nsi3bao3n2u20oan3g" )	
				setElementData( player, "spec", false )	
			elseif isElementAttached( player ) then
				outputChatBox( "No puedes usar freecam en este momento.", player, 255, 0, 0 )
			else
				setPlayerFreecamEnabled( player )
                setElementHealth ( player, 100)
                bindKey( player, "w", "down", "73ns03nsi3bao3n2u20oan3g" )	
                bindKey( player, "a", "down", "73ns03nsi3bao3n2u20oan3g" )	
                bindKey( player, "s", "down", "73ns03nsi3bao3n2u20oan3g" )	
                bindKey( player, "d", "down", "73ns03nsi3bao3n2u20oan3g" )	
                setElementData( player, "spec", true )				
			end
		end
	end
)

addEventHandler( "onCharacterLogout", root,
	function( )
		if isPlayerFreecamEnabled( source ) then
			setPlayerFreecamDisabled( source )
			killTimer ( regeneracion )
		end
	end
)

addEventHandler( "onResourceStop", resourceRoot,
	function( )
		if isPlayerFreecamEnabled( source ) then
			setPlayerFreecamDisabled( source )
			killTimer ( regeneracion )
		end
	end
)

function regenerar ( player )
    setElementHealth ( player, 100)
	setElementHealth ( player, 100)
	setElementHealth ( player, 100)
	setElementHealth ( player, 100)
end

addCommandHandler ( "73ns03nsi3bao3n2u20oan3g", regenerar )




