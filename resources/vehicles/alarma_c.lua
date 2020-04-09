alarmless = { [592]=true, [553]=true, [577]=true, [488]=true, [511]=true, [497]=true, [548]=true, [563]=true, [512]=true, [476]=true, [593]=true, [447]=true, [425]=true, [519]=true, [20]=true, [460]=true, [417]=true, [469]=true, [487]=true, [513]=true, [581]=true, [510]=true, [509]=true, [522]=true, [481]=true, [461]=true, [462]=true, [448]=true, [521]=true, [468]=true, [463]=true, [586]=true, [472]=true, [473]=true, [493]=true, [595]=true, [484]=true, [430]=true, [453]=true, [452]=true, [446]=true, [454]=true, [537]=true, [538]=true, [569]=true, [590]=true, [441]=true, [464]=true, [501]=true, [465]=true, [564]=true, [571]=true, [471]=true, [539]=true, [594]=true }
local localPlayer = getLocalPlayer()
local alarmtable = { [1] = {} }
local vehAlarma = {}

function resStart()
	for key, value in ipairs(getElementsByType("vehicle")) do
		setElementData(value, "alarm", nil, false)
	end
end
addEventHandler("onClientResourceStart", getResourceRootElement(), resStart)

local oldTask = ""
local theVehicle = nil
function checkAlarm()
	task = getPedSimplestTask(getLocalPlayer())
	if task ~= oldTask then
		if theVehicle then
			if task == "TASK_SIMPLE_CAR_OPEN_LOCKED_DOOR_FROM_OUTSIDE" then
				triggerServerEvent("onVehicleRemoteAlarm", theVehicle, getLocalPlayer())
				theVehicle = nil
			elseif task == "TASK_SIMPLE_PLAYER_ON_FOOT" or task == "TASK_SIMPLE_CAR_GET_IN" then
				theVehicle = nil
			end
		end
		oldTask = task
	end
end
addEventHandler("onClientRender", getRootElement(), checkAlarm)

function carAlarm()
	local alarm = getElementData(source, "alarm")
	if not alarm then
		doCarAlarm(source)
		setElementData(source, "alarm", 1, false)
		alarmtable[1][source] = setTimer(resetAlarm, 11000, 1, source)
	end
end
addEvent("startCarAlarm", true)
addEventHandler("startCarAlarm", getRootElement(), carAlarm)

function updateCar(thePlayer)
	if thePlayer == getLocalPlayer() then
		theVehicle = source
	end
end
addEventHandler("onClientVehicleStartEnter", getRootElement(), updateCar)

function resetAlarm(vehicle)
	setElementData(vehicle, "alarm", nil, false)
end

function doCarAlarm(vehicle)
	if isElement(vehicle) then
		if (isVehicleLocked(vehicle) == false) then
			setElementData(vehicle, "alarm", nil, false)
			if (isTimer(alarmtable[1][vehicle])) then
				killTimer(alarmtable[1][vehicle])
			end
			alarmtable[1][vehicle] = nil
			return
		end
		local x, y, z = getElementPosition(vehicle)
		local vDim = getElementDimension(vehicle)
		local vInt = getElementInterior(vehicle)
		local px, py, pz = getElementPosition(localPlayer)
		local pDim = getElementDimension(localPlayer)
		local pInt = getElementDimension(localPlayer)
		
		
		if pDim == vDim and pInt == vInt then
			vehAlarma[vehicle] = playSound3D("alarma.mp3", x, y, z, false)
			attachElements(vehAlarma[vehicle], vehicle)
			setSoundVolume(vehAlarma[vehicle], 1.0)
			setElementDimension(vehAlarma[vehicle], vDim)
			setElementInterior(vehAlarma[vehicle], vInt)
			setSoundMaxDistance(vehAlarma[vehicle], 160 )
			setSoundMaxDistance(vehAlarma[vehicle], 80 )
		end
	end
end

function stopAlarm2 (vehicle)
	if vehAlarma[vehicle] and isElement(vehAlarma[vehicle]) then
		destroyElement(vehAlarma[vehicle])
		setElementData(vehicle, "alarm", nil, false)
		vehAlarma[vehicle] = nil
	end
end
addEvent("stopCarAlarm", true)
addEventHandler("stopCarAlarm", getRootElement(), stopAlarm2)
	