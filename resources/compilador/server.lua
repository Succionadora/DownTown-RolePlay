Resources = {}

for k, v in ipairs(getResources()) do
	table.insert(Resources, getResourceName(v))
end

Current = 1

function CheckFile()
	if Resources[Current] then
		outputDebugString("[Seguridad DTRP] Revisando "..Resources[Current], 0,55,167,220)
		
		local xmlPatch = ":"..Resources[Current].."/meta.xml"
		local xmlFile = xmlLoadFile(xmlPatch)
		if xmlFile then							
			--Map Scripts
			local index = 0
			local scriptNode = xmlFindChild(xmlFile,'script',index)
			if scriptNode then
				repeat
				local nombreRes = tostring(Resources[Current])
				local scriptPath = xmlNodeGetAttribute(scriptNode,'src') or false
				local scriptType = xmlNodeGetAttribute(scriptNode,'type') or "server"
				local scriptSize = xmlNodeGetAttribute(scriptNode, 'size') or 0
				if scriptPath and scriptType:lower() == "client" then
					if string.find(scriptPath:lower(), "luac") then
						local actualFile = fileOpen(":"..Resources[Current].."/"..scriptPath:gsub("luac", "lua"))
						if tonumber(scriptSize) ~= tonumber(fileGetSize(actualFile)) and tonumber(scriptSize) > 0 then
							fileClose(actualFile)
							outputDebugString(scriptPath.." estaba compilado y se ha modificado. Recompilando y reiniciando.",3,220,20,20)
							fileDelete(":"..Resources[Current].."/"..scriptPath)
							local FROM=":"..Resources[Current].."/"..scriptPath:gsub("luac", "lua")
							local TO= ":"..Resources[Current].."/"..scriptPath
							fetchRemote( "https://luac.mtasa.com/index.php?compile=1&debug=0&obfuscate=2", function(data) outputDebugString(scriptPath.." se ha recompilado. Reiniciando.",3,220,20,20) fileSave(TO,data) restartResource(getResourceFromName(nombreRes)) end, fileLoad(FROM), true)
							xmlNodeSetAttribute(scriptNode,'src',scriptPath)
							--outputDebugString("COMPILER SYSTEM: ".. TO.." recompilado y guardado correctamente.",3,0,255,0)
							local file = fileOpen(FROM)
							xmlNodeSetAttribute(scriptNode, 'size', fileGetSize(file))
							fileClose(file)
						else
							fileClose(actualFile)
							--outputDebugString("COMPILER SYSTEM: El archivo "..scriptPath.." no se ha modificado. No se recompilará.",3,220,20,20)
						end
					else
						if scriptSize and tonumber(scriptSize) == -1 then
							outputDebugString(scriptPath.." NO se compila (así está definido.)",3,220,20,20)
						else
							local FROM=":"..Resources[Current].."/"..scriptPath
							local TO= ":"..Resources[Current].."/"..scriptPath.."c"
							fetchRemote( "https://luac.mtasa.com/index.php?compile=1&debug=0&obfuscate=2", function(data) fileSave(TO,data) end, fileLoad(FROM), true )
							xmlNodeSetAttribute(scriptNode,'src',scriptPath..'c')
							outputDebugString("COMPILER SYSTEM: Nuevo archivo ".. FROM..", recompilando. Reinicie en unos segundos manualmente.",3,0,255,0)
							local file = fileOpen(FROM)
							xmlNodeSetAttribute(scriptNode, 'size', fileGetSize(file))
							fileClose(file)
						end
					end
				end
				index = index + 1
				scriptNode = xmlFindChild(xmlFile,'script',index)
				until not scriptNode
			end
			xmlSaveFile(xmlFile)
			xmlUnloadFile(xmlFile)
		else
			outputDebugString("COMPILER SYSTEM: Cant read xmlFile: meta.xml",3,220,20,20)
			return false
		end
	end	
	Current = Current + 1
	setTimer(CheckFile, 50, 1)
end
--addCommandHandler ( "compilec", CheckFile )
addEventHandler("onResourceStart", getResourceRootElement(getThisResource()), CheckFile)

function fileLoad(path)
    local File = fileOpen(path, true)
    if File then
        local data = fileRead(File, 500000000)
        fileClose(File)
        return data
    end
end
 
function fileSave(path, data)
    local File = fileCreate(path)
    if File then
        fileWrite(File, data)
        fileClose(File)
    end
end